<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Servers;

class ServersTest extends CloudApiTestCase
{

    public $properties = [
    'id',
    'name',
    'hostname',
    'ip',
    'status',
    'region',
    'roles',
    'amiType',
    'configuration',
    'flags',
    ];

    public function testGetServers()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Servers/getAllServers.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $servers = new Servers($client);
        $result = $servers->getAll('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\ServersResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\ServerResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetServer()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Servers/getServer.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $server = new Servers($client);
        $result = $server->get('8ff6c046-ec64-4ce4-bea6-27845ec18600', '3');

        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\ServersResponse', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\ServerResponse', $result);

        foreach ($this->properties as $property) {
              $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testUpdateServer()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Servers/updateServer.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $server = new Servers($client);
        $result = $server->update(
            '8ff6c046-ec64-4ce4-bea6-27845ec18600',
            '3',
            ['memcache' => 128]
        );

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('The server configuration is being updated.', $result->message);
    }
}
