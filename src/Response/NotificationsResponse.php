<?php

namespace AcquiaCloudApi\Response;

/**
 * Class NotificationsResponse
 *
 * @package AcquiaCloudApi\Response
 */
class NotificationsResponse extends \ArrayObject
{

    /**
     * MembersResponse constructor.
     *
     * @param array $notifications
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
