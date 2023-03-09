<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\OperationResponse;
use AcquiaCloudApi\Response\SubscriptionResponse;
use AcquiaCloudApi\Response\SubscriptionsResponse;

class Subscriptions extends CloudApiBase
{
    /**
     * Shows all Subscriptions.
     *
     * @return SubscriptionsResponse<SubscriptionResponse>
     */
    public function getAll(): SubscriptionsResponse
    {
        return new SubscriptionsResponse($this->client->request('get', '/subscriptions'));
    }

    /**
     * Shows information about an subscription.
     */
    public function get(string $subscriptionUuid): SubscriptionResponse
    {
        return new SubscriptionResponse(
            $this->client->request(
                'get',
                "/subscriptions/$subscriptionUuid"
            )
        );
    }

    /**
     * Renames an subscription.
     */
    public function rename(string $subscriptionUuid, string $name): OperationResponse
    {

        $options = [
            'json' => [
                'name' => $name,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'put',
                "/subscriptions/$subscriptionUuid",
                $options
            )
        );
    }
}
