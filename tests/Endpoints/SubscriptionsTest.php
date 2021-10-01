<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Subscriptions;

class SubscriptionsTest extends CloudApiTestCase
{
    /**
     * @var mixed[] $properties
     */
    protected $properties = [
        'uuid',
        'name',
        'start_at',
        'expire_at',
        'product',
        'applications_total',
        'applications_used',
        'advisory_hours_total',
        'advisory_hours_used',
        'organization',
        'flags',
        'links'
    ];

    public function testGetSubscriptions(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Subscriptions/getAllSubscriptions.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $subscription = new Subscriptions($client);
        $result = $subscription->getAll();

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\SubscriptionsResponse', $result);
        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\SubscriptionResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetSubscription(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Subscriptions/getSubscription.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $subscription = new Subscriptions($client);
        $result = $subscription->get('8533debb-ae4e-427b-aa34-731719b4201a');

        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\SubscriptionsResponse', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\SubscriptionResponse', $result);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testRenameSubscription(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Subscriptions/renameSubscription.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $subscription = new Subscriptions($client);
        $result = $subscription->rename('8533debb-ae4e-427b-aa34-731719b4201a', "My subscription's new name");

        $requestOptions = [
            'json' => [
                'name' => "My subscription's new name",
            ],
        ];

        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Subscription updated.', $result->message);
    }
}
