<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Connector\Client;
use AcquiaCloudApi\Connector\Connector;
use AcquiaCloudApi\Endpoints\Applications;
use League\OAuth2\Client\Test\Provider\Fake as MockProvider;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Grant\AbstractGrant;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\ResponseInterface;
use Eloquent\Phony\Phpunit\Phony;
use GuzzleHttp\ClientInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class ConnectorTest extends CloudApiTestCase
{

    public function testConnector()
    {
        $config = [
            'key' => 'key',
            'secret' => 'secret'
        ];
        
        $connector = new Connector($config);

        $this->assertEquals(
            $connector::BASE_URI,
            'https://cloud.acquia.com/api'
        );
        $this->assertEquals(
            $connector::URL_ACCESS_TOKEN,
            'https://accounts.acquia.com/api/auth/oauth/token'
        );
    }

    public function testGetAuthenticatedRequest()
    {
        // Clear the cache to make sure we get fresh results during testing.
        $cache = new FilesystemAdapter();
        $foo = $cache->deleteItem('cloudapi-token');

        $config = [
            'key' => 'key',
            'secret' => 'secret'
        ];

        // Create a new Connector and override the provider property set in the constructor.
        $connector = new Connector($config);
        $reflectionClass = new \ReflectionClass('AcquiaCloudApi\Connector\Connector');

        $provider = new MockProvider([
            'clientId' => 'mock_client_id',
            'clientSecret' => 'mock_secret',
            'redirectUri' => 'none',
        ]);

        $providerProperty = $reflectionClass->getProperty('provider');
        $providerProperty->setAccessible(true);
        $providerProperty->setValue($connector, $provider);

        // Create the mock response from the call to get the access token.
        $expires = time() + 300;
        $raw_response = ['access_token' => 'acquia-token', 'expires' => $expires, 'resource_owner_id' => 3];

        $grant = Phony::mock(AbstractGrant::class);
        $grant->prepareRequestParameters->returns([]);

        $stream = Phony::mock(StreamInterface::class);
        $stream->__toString->returns(json_encode($raw_response));

        $response = Phony::mock(ResponseInterface::class);
        $response->getBody->returns($stream->get());
        $response->getHeader->with('content-type')->returns('application/json');

        $client = Phony::mock(ClientInterface::class);
        $client->send->returns($response->get());

        $provider->setHttpClient($client->get());

        // Create the request and check it matches our expectations.
        $request = $connector->createRequest('get', '/account');
        $this->assertInstanceOf('GuzzleHttp\Psr7\Request', $request);

        $expectedHeaders = [
            'Host' => [
                'cloud.acquia.com',
            ],
            'Authorization' => [
                'Bearer acquia-token',
            ]
        ];
        $expectedHeaderNames = [
            'authorization' => 'Authorization',
            'host' => 'Host',
        ];

        $this->assertAttributeSame($expectedHeaders, 'headers', $request);
        $this->assertAttributeSame($expectedHeaderNames, 'headerNames', $request);

        // Check the cache to make sure that the token has been cached successfully.
        $cache = new FilesystemAdapter();
        $accessToken = $cache->getItem('cloudapi-token')->get();

        // Ensure that the cached item is an AccessToken and that it contains the values we set above.
        $this->assertInstanceOf('League\OAuth2\Client\Token\AccessToken', $accessToken);
        $this->assertAttributeSame('acquia-token', 'accessToken', $accessToken);
        $this->assertAttributeSame(3, 'resourceOwnerId', $accessToken);
        $this->assertAttributeSame($expires, 'expires', $accessToken);

        // Delete the cached token again to clean up.
        $delete = $cache->deleteItem('cloudapi-token');
        $this->assertTrue($delete);
    }
}
