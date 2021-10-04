<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<SubscriptionResponse>
 */
class SubscriptionsResponse extends CollectionResponse
{

    /**
     * @param array<object> $subscriptions
     */
    public function __construct($subscriptions)
    {
        parent::__construct('SubscriptionResponse', $subscriptions);
    }
}
