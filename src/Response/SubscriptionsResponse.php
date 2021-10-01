<?php

namespace AcquiaCloudApi\Response;

/**
 * @template TValue
 * @template-extends \ArrayObject<int,TValue>
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
