<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Servers;
use AcquiaCloudApi\Response\ServerResponse;
use AcquiaCloudApi\Response\ServersResponse;

class ServersTest extends CloudApiTestCase
{
    public function testGetServers(): void
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Servers/getAllServers.json');
        $client = $this->getMockClient($response);

        $servers = new Servers($client);
        $result = $servers->getAll('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(ServerResponse::class, $record);
        }
    }

    public function testGetServer(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Servers/getServer.json');
        $client = $this->getMockClient($response);

        $server = new Servers($client);
        $result = $server->get('8ff6c046-ec64-4ce4-bea6-27845ec18600', '3');

        $this->assertNotInstanceOf(ServersResponse::class, $result);
    }

    public function testUpdateServer(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Servers/updateServer.json');
        $client = $this->getMockClient($response);

        $server = new Servers($client);
        $result = $server->update(
            '8ff6c046-ec64-4ce4-bea6-27845ec18600',
            '3',
            ['memcache' => 128]
        );

        $this->assertEquals('The server configuration is being updated.', $result->message);
    }
}
