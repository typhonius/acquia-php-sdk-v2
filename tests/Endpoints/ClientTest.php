<?php

use AcquiaCloudApi\CloudApi\Client;
use AcquiaCloudApi\CloudApi\Connector;
use GuzzleHttp\Client as GuzzleClient;

class ClientTest extends CloudApiTestCase
{

    protected $properties = [
        'uuid',
        'name',
        'hosting',
        'subscription',
        'organization',
        'type',
        'flags',
        'status',
        'links'
    ];

    public function testClearQuery()
    {
        $connector = new Connector(new GuzzleClient);
        $client = Client::factory(
            [
                'key' => 'd0697bfc-7f56-4942-9205-b5686bf5b3f5',
                'secret' => 'D5UfO/4FfNBWn4+0cUwpLOoFzfP7Qqib4AoY+wYGsKE=',
            ],
            $connector
            );
        $this->assertTrue(empty($client->getQuery()));
    }

    public function testApplications()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getApplications.json');
        $connector = $this
            ->getMockBuilder('AcquiaCloudApi\CloudApi\Connector')
            ->disableOriginalConstructor()
            ->setMethods(['makeRequest'])
            ->getMock();
        $connector
            ->expects($this->atLeastOnce())
            ->method('makeRequest')
            ->willReturn($response);
        $client = Client::factory(
            [
                'key' => 'd0697bfc-7f56-4942-9205-b5686bf5b3f5',
                'secret' => 'D5UfO/4FfNBWn4+0cUwpLOoFzfP7Qqib4AoY+wYGsKE=',
            ],
            $connector);
        $result = $client->applications();
        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\ApplicationsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\ApplicationResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }
}
