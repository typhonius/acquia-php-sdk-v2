<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\NotificationResponse;
use AcquiaCloudApi\Response\NotificationsResponse;

/**
 * Class Notifications
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Notifications extends CloudApiBase
{
    /**
     * Returns details about a notification.
     *
     * @param string $notificationUuid
     *
     * @return NotificationResponse
     */
    public function get(string $notificationUuid): NotificationResponse
    {
        return new NotificationResponse(
            $this->client->request(
                'get',
                "/notifications/$notificationUuid"
            )
        );
    }

    /**
     * Returns a list of notifications.
     *
     * @param string $applicationUuid
     *
     * @return NotificationsResponse<NotificationResponse>
     */
    public function getAll(string $applicationUuid): NotificationsResponse
    {
        return new NotificationsResponse(
            $this->client->request(
                'get',
                "/applications/$applicationUuid/notifications"
            )
        );
    }
}
