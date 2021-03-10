<?php

namespace AcquiaCloudApi\Tests\Connector;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Connector\Connector;
use AcquiaCloudApi\Connector\ConnectorInterface;
use League\OAuth2\Client\Test\Provider\Fake as MockProvider;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\ResponseInterface;
use Eloquent\Phony\Phpunit\Phony;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\AbstractAdapter;
use Webmozart\PathUtil\Path;

class ConnectorTest extends CloudApiTestCase
{

    /**
     * @var ConnectorInterface $connector
     */
    public $connector;

    /**
     * @var AbstractAdapter $cache
     */
    public $cache;

    public function setUp(): void
    {
        $this->createConnector();
        $this->clearCache();
    }

    public function tearDown(): void
    {
        // Delete the cached token again to clean up.
        $delete = $this->cache->deleteItem('cloudapi-token');
        $this->assertTrue($delete);
    }

    public function testConnector(): void
    {
        $this->assertEquals(
            $this->connector::BASE_URI,
            'https://cloud.acquia.com/api'
        );
        $this->assertEquals(
            $this->connector::URL_ACCESS_TOKEN,
            'https://accounts.acquia.com/api/auth/oauth/token'
        );

        $connectorReflectionClass = new \ReflectionClass('AcquiaCloudApi\Connector\Connector');
        $providerProperty = $connectorReflectionClass->getProperty('provider');
        $providerProperty->setAccessible(true);
        $provider = $providerProperty->getValue($this->connector);

        $this->assertInstanceOf('League\OAuth2\Client\Provider\GenericProvider', $provider);

        $providerReflectionClass = new \ReflectionClass('League\OAuth2\Client\Provider\GenericProvider');
        $clientId = $providerReflectionClass->getProperty('clientId');
        $clientId->setAccessible(true);

        $clientSecret = $providerReflectionClass->getProperty('clientSecret');
        $clientSecret->setAccessible(true);

        $this->assertEquals('key', $clientId->getValue($provider));
        $this->assertEquals('secret', $clientSecret->getValue($provider));
    }

    public function testConnectorBaseUri(): void
    {
        $base_uri = 'https://test-cloud.acquia.com/api';
        $this->createConnector($base_uri);
        $this->assertEquals(
            $this->connector->getBaseUri(),
            $base_uri
        );
    }


    public function testGetAuthenticatedRequest(): void
    {
        // Override the provider property set in the constructor.
        $reflectionClass = new \ReflectionClass('AcquiaCloudApi\Connector\Connector');

        $provider = new MockProvider(
            [
            'clientId' => 'mock_client_id',
            'clientSecret' => 'mock_secret',
            'redirectUri' => 'none',
            ]
        );

        $providerProperty = $reflectionClass->getProperty('provider');
        $providerProperty->setAccessible(true);
        $providerProperty->setValue($this->connector, $provider);

        // Create the mock response from the call to get the access token.
        $expires = time() + 300;
        $raw_response = ['access_token' => 'acquia-token', 'expires' => $expires, 'resource_owner_id' => 3];

        $stream = Phony::mock(StreamInterface::class);
        $stream->__toString->returns(json_encode($raw_response));

        $response = Phony::mock(ResponseInterface::class);
        $response->getBody->returns($stream->get());
        $response->getHeader->with('content-type')->returns('application/json');

        $client = Phony::mock(ClientInterface::class);
        $client->send->returns($response->get());

        $provider->setHttpClient($client->get());

        // Create the request and check it matches our expectations.
        $request = $this->connector->createRequest('get', '/account');
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

        $requestReflectionClass = new \ReflectionClass('GuzzleHttp\Psr7\Request');
        $headerProperty = $requestReflectionClass->getProperty('headers');
        $headerNamesProperty = $requestReflectionClass->getProperty('headerNames');
        $headerProperty->setAccessible(true);
        $headerNamesProperty->setAccessible(true);
        $headers = $headerProperty->getValue($request);
        $headerNames = $headerNamesProperty->getValue($request);

        $this->assertEquals($expectedHeaders, $headers);
        $this->assertEquals($expectedHeaderNames, $headerNames);

        // Check the cache to make sure that the token has been cached successfully.
        $accessToken = $this->cache->getItem('cloudapi-token')->get();

        // Ensure that the cached item is an AccessToken and that it contains the values we set above.
        $accessTokenReflectionClass = new \ReflectionClass('League\OAuth2\Client\Token\AccessToken');
        $accessTokenProperty = $accessTokenReflectionClass->getProperty('accessToken');
        $resourceOwnerProperty = $accessTokenReflectionClass->getProperty('resourceOwnerId');
        $expiresProperty = $accessTokenReflectionClass->getProperty('expires');
        $accessTokenProperty->setAccessible(true);
        $resourceOwnerProperty->setAccessible(true);
        $expiresProperty->setAccessible(true);
        $token = $accessTokenProperty->getValue($accessToken);
        $resourceOwner = $resourceOwnerProperty->getValue($accessToken);
        $expiry = $expiresProperty->getValue($accessToken);

        $this->assertInstanceOf('League\OAuth2\Client\Token\AccessToken', $accessToken);
        $this->assertEquals('acquia-token', $token);
        $this->assertEquals(3, $resourceOwner);
        $this->assertEquals($expires, $expiry);
    }

    public function testGuzzleRequest(): void
    {
        // Fake a Guzzle client for the request and response.
        $client = new GuzzleClient(['handler' => new MockHandler([new Response()])]);

        // Mock the connector.
        $request = new Request('GET', 'https://cloud.acquia.com/api/account');

        $this->connector = $this
            ->getMockBuilder('AcquiaCloudApi\Connector\Connector')
            ->disableOriginalConstructor()
            ->setMethods(['createRequest'])
            ->getMock();

        $this->connector
            ->expects($this->atLeastOnce())
            ->method('createRequest')
            ->willReturn($request);

        // Add our fake Guzzle client to the Connector class.
        $reflectionClass = new \ReflectionClass('AcquiaCloudApi\Connector\Connector');
        $providerProperty = $reflectionClass->getProperty('client');
        $providerProperty->setAccessible(true);
        $providerProperty->setValue($this->connector, $client);

        // Create the request and check it matches our expectations.
        $return = $this->connector->sendRequest('get', '/account', []);

        // Basic checks to make sure that we get a return code.
        $this->assertEquals(200, $return->getStatusCode());
        $this->assertEquals('OK', $return->getReasonPhrase());
    }

    protected function clearCache(): void
    {
        // Clear the cache to make sure we get fresh results during testing.
        $directory = sprintf('%s%s%s', Path::getHomeDirectory(), \DIRECTORY_SEPARATOR, '.acquia-php-sdk-v2');
        $this->cache = new FilesystemAdapter('cache', 0, $directory);
        $this->cache->deleteItem('cloudapi-token');
    }

    protected function createConnector(string $base_url = null): void
    {
        $config = [
          'key' => 'key',
          'secret' => 'secret'
        ];

        $this->connector = new Connector($config, $base_url);
    }
}
