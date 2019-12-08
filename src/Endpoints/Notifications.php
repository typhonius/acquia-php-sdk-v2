<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;
use AcquiaCloudApi\Response\NotificationResponse;
use AcquiaCloudApi\Response\NotificationsResponse;

/**
 * Class Client
 * @package AcquiaCloudApi\CloudApi
 */
class Notifications implements CloudApi
{

    /** @var ClientInterface The API client. */
    protected $client;

    /**
     * Client constructor.
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }
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
