<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;
use AcquiaCloudApi\Response\OperationResponse;
use AcquiaCloudApi\Response\ServersResponse;
use AcquiaCloudApi\Response\ServerResponse;

/**
 * Class Client
 * @package AcquiaCloudApi\CloudApi
 */
class Servers implements CloudApi
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
     * Gets information about a single server.
     *
     * @param string $environmentUuid
     * @param string $serverId
     * @return ServerResponse
     */
    public function get($environmentUuid, $serverId)
    {
        return new ServerResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/servers/${serverId}"
            )
        );
    }

    /**
     * Modifies configuration settings for a server.
     *
     * @param string $environmentUuid
     * @param string $serverId
     * @param array  $config
     * @return OperationResponse
     */
    public function update($environmentUuid, $serverId, array $config)
    {

        return new OperationResponse(
            $this->client->request(
                'put',
                "/environments/${environmentUuid}/servers/${serverId}",
                $config
            )
        );
    }

    /**
     * Show all servers associated with an environment.
     *
     * @param string $environmentUuid
     * @return ServersResponse
     */
    public function getAll($environmentUuid)
    {
        return new ServersResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/servers"
            )
        );
    }
}
