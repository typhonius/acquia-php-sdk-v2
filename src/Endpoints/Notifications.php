<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\NotificationResponse;
use AcquiaCloudApi\Response\NotificationsResponse;

/**
 * Class Notifications
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Notifications extends CloudApiBase implements CloudApiInterface
{
    /**
     * Returns details about a notification.
     *
     * @param  string $notificationUuid
     * @return NotificationResponse
     */
    public function get($notificationUuid): NotificationResponse
    {
        return new NotificationResponse(
            $this->client->request(
                'get',
                "/notifications/${notificationUuid}"
            )
        );
    }

    /**
     * Returns a list of notifications.
     *
     * @param  string $applicationUuid
     * @return NotificationsResponse<NotificationResponse>
     */
    public function getAll($applicationUuid): NotificationsResponse
    {
        return new NotificationsResponse(
            $this->client->request(
                'get',
                "/applications/${applicationUuid}/notifications"
            )
        );
    }
}
