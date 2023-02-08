<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Subscriptions;
use AcquiaCloudApi\Response\SubscriptionsResponse;
use AcquiaCloudApi\Response\SubscriptionResponse;

class SubscriptionsTest extends CloudApiTestCase
{
    public function testGetSubscriptions(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Subscriptions/getAllSubscriptions.json');
        $client = $this->getMockClient($response);

        $subscription = new Subscriptions($client);
        $result = $subscription->getAll();

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(SubscriptionResponse::class, $record);
        }
    }

    public function testGetSubscription(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Subscriptions/getSubscription.json');
        $client = $this->getMockClient($response);

        $subscription = new Subscriptions($client);
        $result = $subscription->get('8533debb-ae4e-427b-aa34-731719b4201a');

        $this->assertNotInstanceOf(SubscriptionsResponse::class, $result);
    }

    public function testRenameSubscription(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Subscriptions/renameSubscription.json');
        $client = $this->getMockClient($response);

        $subscription = new Subscriptions($client);
        $result = $subscription->rename('8533debb-ae4e-427b-aa34-731719b4201a', "My subscription's new name");

        $requestOptions = [
            'json' => [
                'name' => "My subscription's new name",
            ],
        ];

        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals('Subscription updated.', $result->message);
    }
}
