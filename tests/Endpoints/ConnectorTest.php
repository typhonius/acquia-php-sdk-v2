<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Connector\Client;
use AcquiaCloudApi\Connector\Connector;
use AcquiaCloudApi\Endpoints\Applications;
use League\OAuth2\Client\Test\Provider\Fake as MockProvider;
use League\OAuth2\Client\Token\AccessToken;

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
        $config = [
            'key' => 'key',
            'secret' => 'secret'
        ];

        $connector = new Connector($config);
        $reflectionClass = new \ReflectionClass('AcquiaCloudApi\Connector\Connector');

        $token = new AccessToken(['access_token' => 'acquia-token', 'expires_in' => 300]);
        $accessTokenProperty = $reflectionClass->getProperty('accessToken');
        $accessTokenProperty->setAccessible(true);
        $accessTokenProperty->setValue($connector, $token);

        $provider = new MockProvider();
        $providerProperty = $reflectionClass->getProperty('provider');
        $providerProperty->setAccessible(true);
        $providerProperty->setValue($connector, $provider);

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
    }
}
