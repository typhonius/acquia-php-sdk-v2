<?php

namespace AcquiaCloudApi\Tests\Connector;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Connector\Connector;
use AcquiaCloudApi\Connector\ConnectorInterface;
use GuzzleHttp\Psr7\Uri;
use League\OAuth2\Client\Test\Provider\Fake as MockProvider;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\AbstractAdapter;
use Symfony\Component\Filesystem\Path;

class ConnectorTest extends CloudApiTestCase
{
    public ConnectorInterface $connector;

    public AbstractAdapter $cache;

    public function setUp(): void
    {
        $this->createConnector();
        $this->clearCache();
    }

    public function tearDown(): void
    {
        // Delete the cached token again to clean up.
        $delete = $this->cache->deleteItem('cloudapi-token-key');
        $this->assertTrue($delete);
    }

    public function testConnector(): void
    {
        $this->assertEquals(
            'https://cloud.acquia.com/api',
            $this->connector::BASE_URI
        );
        $this->assertEquals(
            'https://accounts.acquia.com/api/auth/oauth/token',
            $this->connector::URL_ACCESS_TOKEN
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

    public function testConnectorUrlAccessToken(): void
    {
        $url_access_token = 'https://test-accounts.acquia.com/api/auth/oauth/token';
        $this->createConnector(null, $url_access_token);
        $this->assertEquals(
            $this->connector->getUrlAccessToken(),
            $url_access_token
        );
    }

    public function testGetAuthenticatedRequest(): void
    {
        // Override the provider property set in the constructor.
        $reflectionClass = new \ReflectionClass(Connector::class);

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

        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn(json_encode($raw_response));

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn($stream);
        $response->method('getHeader')->with('content-type')->willReturn(['application/json']);

        $client = $this->createMock(ClientInterface::class);
        $client->method('send')->willReturn($response);

        $provider->setHttpClient($client);

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
        $expectedUri = new Uri('https://cloud.acquia.com/api/account');

        $requestReflectionClass = new \ReflectionClass('GuzzleHttp\Psr7\Request');
        $headerProperty = $requestReflectionClass->getProperty('headers');
        $headerNamesProperty = $requestReflectionClass->getProperty('headerNames');
        $uriProperty = $requestReflectionClass->getProperty('uri');
        $headerProperty->setAccessible(true);
        $headerNamesProperty->setAccessible(true);
        $uriProperty->setAccessible(true);
        $headers = $headerProperty->getValue($request);
        $headerNames = $headerNamesProperty->getValue($request);
        $uri = $uriProperty->getValue($request);

        $this->assertEquals($expectedHeaders, $headers);
        $this->assertEquals($expectedHeaderNames, $headerNames);
        $this->assertEquals($expectedUri, $uri);

        // Check the cache to make sure that the token has been cached successfully.
        $accessToken = $this->cache->getItem('cloudapi-token-key')->get();
        $this->assertNotNull($accessToken);

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

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testGuzzleRequest(): void
    {
        // Fake a Guzzle client for the request and response.
        $client = new GuzzleClient(['handler' => new MockHandler([new Response()])]);

        // Mock the connector.
        $request = new Request('GET', 'https://cloud.acquia.com/api/account');

        $this->connector = $this
            ->getMockBuilder(Connector::class)
            ->disableOriginalConstructor()
            ->setMethods(['createRequest'])
            ->getMock();

        $this->connector
            ->expects($this->atLeastOnce())
            ->method('createRequest')
            ->willReturn($request);

        // Add our fake Guzzle client to the Connector class.
        $reflectionClass = new \ReflectionClass(Connector::class);
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
        $xdgCacheHome = getenv('XDG_CACHE_HOME');
        if (!$xdgCacheHome) {
            $xdgCacheHome = Path::join(Path::getHomeDirectory(), '.cache');
        }
        $directory = Path::join($xdgCacheHome, 'acquia-php-sdk-v2');
        $this->cache = new FilesystemAdapter('cache', 0, $directory);
        $this->cache->deleteItem('cloudapi-token-key');
    }

    protected function createConnector(?string $base_url = null, ?string $url_access_token = null): void
    {
        $config = [
          'key' => 'key',
          'secret' => 'secret'
        ];

        $this->connector = new Connector($config, $base_url, $url_access_token);
    }
}
