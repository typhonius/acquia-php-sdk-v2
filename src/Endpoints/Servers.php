<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\OperationResponse;
use AcquiaCloudApi\Response\ServersResponse;
use AcquiaCloudApi\Response\ServerResponse;

/**
 * Class Servers
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Servers extends CloudApiBase implements CloudApiInterface
{
    /**
     * Gets information about a single server.
     *
     * @param  string $environmentUuid
     * @param  string $serverId
     * @return ServerResponse
     */
    public function get($environmentUuid, $serverId): ServerResponse
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
     * @param  string  $environmentUuid
     * @param  string  $serverId
     * @param  mixed[] $config
     * @return OperationResponse
     */
    public function update($environmentUuid, $serverId, array $config): OperationResponse
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
     * @param  string $environmentUuid
     * @return ServersResponse<ServerResponse>
     */
    public function getAll($environmentUuid): ServersResponse
    {
        return new ServersResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/servers"
            )
        );
    }
}
