<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Connector\Client;
use AcquiaCloudApi\Connector\Connector;
use AcquiaCloudApi\Endpoints\Application;

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
}
