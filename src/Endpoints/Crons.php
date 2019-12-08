<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;
use AcquiaCloudApi\Response\CronsResponse;
use AcquiaCloudApi\Response\CronResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Client
 * @package AcquiaCloudApi\CloudApi
 */
class Crons implements CloudApi
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
     * Show all cron tasks for an environment.
     *
     * @param string $environmentUuid The environment ID
     * @return CronsResponse
     */
    public function getAll($environmentUuid)
    {
        return new CronsResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/crons"
            )
        );
    }

    /**
     * Get information about a cron task.
     *
     * @param string $environmentUuid The environment ID
     * @param int    $cronId
     * @return CronResponse
     */
    public function get($environmentUuid, $cronId)
    {
        return new CronResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/crons/${cronId}"
            )
        );
    }

    /**
     * Add a cron task.
     *
     * @param string $environmentUuid
     * @param string $command
     * @param string $frequency
     * @param string $label
     * @return OperationResponse
     */
    public function create($environmentUuid, $command, $frequency, $label, $serverId = null)
    {

        $options = [
            'form_params' => [
                'command' => $command,
                'frequency' => $frequency,
                'label' => $label,
                'server_id' => $serverId
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/environments/${environmentUuid}/crons", $options)
        );
    }

    /**
     * Update a cron task.
     *
     * @param string $environmentUuid
     * @param string $command
     * @param string $frequency
     * @param string $label
     * @return OperationResponse
     */
    public function update($environmentUuid, $cronId, $command, $frequency, $label, $serverId = null)
    {

        $options = [
            'form_params' => [
                'command' => $command,
                'frequency' => $frequency,
                'label' => $label,
                'server_id' => $serverId
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/environments/${environmentUuid}/crons/${cronId}", $options)
        );
    }

    /**
     * Delete a cron task.
     *
     * @param string $environmentUuid
     * @param int    $cronId
     * @return OperationResponse
     */
    public function delete($environmentUuid, $cronId)
    {
        return new OperationResponse(
            $this->client->request('delete', "/environments/${environmentUuid}/crons/${cronId}")
        );
    }

    /**
     * Disable a cron task.
     *
     * @param string $environmentUuid
     * @param int    $cronId
     * @return OperationResponse
     */
    public function disable($environmentUuid, $cronId)
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentUuid}/crons/${cronId}/actions/disable"
            )
        );
    }

    /**
     * Enable a cron task.
     *
     * @param string $environmentUuid
     * @param int    $cronId
     * @return OperationResponse
     */
    public function enable($environmentUuid, $cronId)
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentUuid}/crons/${cronId}/actions/enable"
            )
        );
    }
}
