<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\SubscriptionResponse>
 */
class SubscriptionsResponse extends \ArrayObject
{

    /**
     * @param array<object> $subscriptions
     */
    public function __construct($subscriptions)
    {
        parent::__construct(
            array_map(
                function ($subscription) {
                    return new SubscriptionResponse($subscription);
                },
                $subscriptions
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
