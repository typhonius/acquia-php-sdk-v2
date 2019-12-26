<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;
use AcquiaCloudApi\Response\NotificationResponse;
use AcquiaCloudApi\Response\NotificationsResponse;

/**
 * Class Notifications
 * @package AcquiaCloudApi\CloudApi
 */
class Notifications extends CloudApiBase implements CloudApiInterface
{

    /**
     * Returns details about a notification.
     *
     * @return NotificationResponse
     */
    public function get($notificationUuid)
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
     * @param string $applicationUuid
     *
     * @return NotificationsResponse
     */
    public function getAll($applicationUuid)
    {
        return new NotificationsResponse(
            $this->client->request(
                'get',
                "/applications/${applicationUuid}/notifications"
            )
        );
    }
}
