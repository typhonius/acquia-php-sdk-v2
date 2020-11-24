<?php

namespace AcquiaCloudApi\Response;

/**
 * @template TValue
 * @template-extends \ArrayObject<int,TValue>
 */
class NotificationsResponse extends \ArrayObject
{

    /**
     * @param array<object> $notifications
     */
    public function __construct($notifications)
    {
        parent::__construct(
            array_map(
                function ($notification) {
                    return new NotificationResponse($notification);
                },
                $notifications
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
