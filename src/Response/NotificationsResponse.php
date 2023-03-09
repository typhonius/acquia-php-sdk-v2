<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\NotificationResponse>
 */
class NotificationsResponse extends \ArrayObject
{
    /**
     * @param array<object> $notifications
     */
    public function __construct(array $notifications)
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
