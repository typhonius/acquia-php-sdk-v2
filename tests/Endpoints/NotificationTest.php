<?php

use AcquiaCloudApi\CloudApi\Client;

class NotificationTest extends CloudApiTestCase
{

    protected $properties = [
    'uuid',
    'event',
    'label',
    'description',
    'created_at',
    'completed_at',
    'status',
    'progress',
    'context',
    'links'
    ];

    public function testGetNotification()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getNotification.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->notification('f4b37e3c-1g96-4ed4-ad20-3081fe0f9545');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\NotificationResponse', $result);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }
}
