<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\OperationResponse;
use AcquiaCloudApi\Response\ServerResponse;
use AcquiaCloudApi\Response\ServersResponse;

/**
 * Class Servers
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Servers extends CloudApiBase
{
    /**
     * Gets information about a single server.
     *
     *
     */
    public function get(string $environmentUuid, string $serverId): ServerResponse
    {
        return new ServerResponse(
            $this->client->request(
                'get',
                "/environments/$environmentUuid/servers/$serverId"
            )
        );
    }

    /**
     * Modifies configuration settings for a server.
     *
     * @param mixed[] $config
     *
     */
    public function update(string $environmentUuid, string $serverId, array $config): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'put',
                "/environments/$environmentUuid/servers/$serverId",
                $config
            )
        );
    }

    /**
     * Show all servers associated with an environment.
     *
     *
     * @return ServersResponse<ServerResponse>
     */
    public function getAll(string $environmentUuid): ServersResponse
    {
        return new ServersResponse(
            $this->client->request(
                'get',
                "/environments/$environmentUuid/servers"
            )
        );
    }
}
