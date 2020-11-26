<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<NotificationResponse>
 */
class NotificationsResponse extends CollectionResponse
{

    /**
     * @param array<object> $notifications
     */
    public function __construct($notifications)
    {
        parent::__construct('NotificationResponse', $notifications);
    }
}
