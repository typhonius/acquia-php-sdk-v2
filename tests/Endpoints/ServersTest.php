<?php

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

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getServers.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->servers('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\ServersResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\ServerResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }
}
