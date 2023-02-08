<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Notifications;
use AcquiaCloudApi\Response\NotificationResponse;

class NotificationTest extends CloudApiTestCase
{
    public function testGetNotification(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Notifications/getNotification.json');
        $client = $this->getMockClient($response);

        $notifications = new Notifications($client);

        $notifications->get('f4b37e3c-1g96-4ed4-ad20-3081fe0f9545');
    }

    public function testGetNotifications(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Notifications/getAllNotifications.json');
        $client = $this->getMockClient($response);

        $notifications = new Notifications($client);
        $result = $notifications->getAll('f4b37e3c-1g96-4ed4-ad20-3081fe0f9545');

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(NotificationResponse::class, $record);
        }
    }
}
