<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;
use AcquiaCloudApi\Response\PermissionsResponse;

/**
 * Class Client
 * @package AcquiaCloudApi\CloudApi
 */
class Permissions implements CloudApi
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
     * Show all available permissions.
     *
     * @return PermissionsResponse
     */
    public function get()
    {
        return new PermissionsResponse($this->client->request('get', '/permissions'));
    }
}
