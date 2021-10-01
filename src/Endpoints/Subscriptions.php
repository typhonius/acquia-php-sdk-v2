<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\OperationResponse;
use AcquiaCloudApi\Response\SubscriptionResponse;
use AcquiaCloudApi\Response\SubscriptionsResponse;

class Subscriptions extends CloudApiBase implements CloudApiInterface
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
     *
     * @param  string $subscriptionUuid
     * @return SubscriptionResponse
     */
    public function get($subscriptionUuid): SubscriptionResponse
    {
        return new SubscriptionResponse(
            $this->client->request(
                'get',
                "/subscriptions/${subscriptionUuid}"
            )
        );
    }

    /**
     * Renames an subscription.
     *
     * @param  string $subscriptionUuid
     * @param  string $name
     * @return OperationResponse
     */
    public function rename($subscriptionUuid, $name): OperationResponse
    {

        $options = [
            'json' => [
                'name' => $name,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'put',
                "/subscriptions/${subscriptionUuid}",
                $options
            )
        );
    }
}
