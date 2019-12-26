<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\CloudApi\Client;
use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Notifications;
use AcquiaCloudApi\Endpoints\Applications;

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
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Notifications/getNotification.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $notifications = new Notifications($client);

        $result = $notifications->get('f4b37e3c-1g96-4ed4-ad20-3081fe0f9545');
        $this->assertInstanceOf('\AcquiaCloudApi\Response\NotificationResponse', $result);
        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testGetNotifications()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Notifications/getAllNotifications.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $notifications = new Notifications($client);
        $result = $notifications->getAll('f4b37e3c-1g96-4ed4-ad20-3081fe0f9545');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\NotificationsResponse', $result);
        $this->assertInstanceOf('\ArrayObject', $result);
        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\NotificationResponse', $record);
            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }
}
