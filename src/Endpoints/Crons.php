<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\CronResponse;
use AcquiaCloudApi\Response\CronsResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Crons
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Crons extends CloudApiBase
{
    /**
     * Show all cron tasks for an environment.
     *
     * @param string $environmentUuid The environment ID
     * @return CronsResponse<CronResponse>
     */
    public function getAll(string $environmentUuid): CronsResponse
    {
        return new CronsResponse(
            $this->client->request(
                'get',
                "/environments/$environmentUuid/crons"
            )
        );
    }

    /**
     * Get information about a cron task.
     *
     * @param string $environmentUuid The environment ID
     */
    public function get(string $environmentUuid, int $cronId): CronResponse
    {
        return new CronResponse(
            $this->client->request(
                'get',
                "/environments/$environmentUuid/crons/$cronId"
            )
        );
    }

    /**
     * Add a cron task.
     */
    public function create(
        string $environmentUuid,
        string $command,
        string $frequency,
        string $label,
        ?string $serverId = null
    ): OperationResponse {

        $options = [
            'json' => [
                'command' => $command,
                'frequency' => $frequency,
                'label' => $label,
                'server_id' => $serverId,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/environments/$environmentUuid/crons", $options)
        );
    }

    /**
     * Update a cron task.
     */
    public function update(
        string $environmentUuid,
        string $cronId,
        string $command,
        string $frequency,
        string $label,
        ?string $serverId = null
    ): OperationResponse {

        $options = [
            'json' => [
                'command' => $command,
                'frequency' => $frequency,
                'label' => $label,
            ],
        ];
        if ($serverId) {
            $options['json']['server_id'] = $serverId;
        }

        return new OperationResponse(
            $this->client->request('put', "/environments/$environmentUuid/crons/$cronId", $options)
        );
    }

    /**
     * Delete a cron task.
     */
    public function delete(string $environmentUuid, int $cronId): OperationResponse
    {
        return new OperationResponse(
            $this->client->request('delete', "/environments/$environmentUuid/crons/$cronId")
        );
    }

    /**
     * Disable a cron task.
     */
    public function disable(string $environmentUuid, int $cronId): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/$environmentUuid/crons/$cronId/actions/disable"
            )
        );
    }

    /**
     * Enable a cron task.
     */
    public function enable(string $environmentUuid, int $cronId): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/$environmentUuid/crons/$cronId/actions/enable"
            )
        );
    }
}
