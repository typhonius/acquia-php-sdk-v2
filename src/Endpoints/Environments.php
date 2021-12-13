<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\EnvironmentResponse;
use AcquiaCloudApi\Response\EnvironmentsResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Environments
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Environments extends CloudApiBase implements CloudApiInterface
{
    /**
     * Copies files from an environment to another environment.
     *
     * @param  string $environmentUuidFrom
     * @param  string $environmentUuidTo
     * @return OperationResponse
     */
    public function copyFiles($environmentUuidFrom, $environmentUuidTo): OperationResponse
    {
        $options = [
            'json' => [
                'source' => $environmentUuidFrom,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/environments/${environmentUuidTo}/files", $options)
        );
    }

    /**
     * Gets information about an environment.
     *
     * @param  string $environmentUuid
     * @return EnvironmentResponse
     */
    public function get($environmentUuid): EnvironmentResponse
    {
        return new EnvironmentResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}"
            )
        );
    }

    /**
     * Shows all environments in an application.
     *
     * @param  string $applicationUuid
     * @return EnvironmentsResponse<EnvironmentResponse>
     */
    public function getAll($applicationUuid): EnvironmentsResponse
    {
        return new EnvironmentsResponse(
            $this->client->request(
                'get',
                "/applications/${applicationUuid}/environments"
            )
        );
    }

    /**
     * Modifies configuration settings for an environment.
     *
     * @param  string  $environmentUuid
     * @param  mixed[] $config
     * @return OperationResponse
     */
    public function update($environmentUuid, array $config): OperationResponse
    {

        $options = [
            'json' => $config,
        ];

        return new OperationResponse(
            $this->client->request(
                'put',
                "/environments/${environmentUuid}",
                $options
            )
        );
    }

    /**
     * Renames an environment.
     *
     * @param  string $environmentUuid
     * @param  string $label
     * @return OperationResponse
     */
    public function rename($environmentUuid, $label): OperationResponse
    {

        $options = [
            'json' => [
                'label' => $label,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentUuid}/actions/change-label",
                $options
            )
        );
    }

    /**
     * Enable livedev mode for an environment.
     *
     * @param  string $environmentUuid
     * @return OperationResponse
     */
    public function enableLiveDev($environmentUuid): OperationResponse
    {
        return new OperationResponse(
            $this->client->request('post', "/environments/${environmentUuid}/livedev/actions/enable")
        );
    }

    /**
     * Disable livedev mode for an environment.
     *
     * @param  string $environmentUuid
     * @return OperationResponse
     */
    public function disableLiveDev($environmentUuid): OperationResponse
    {

        $options = [
            'json' => [
                'discard' => 1,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentUuid}/livedev/actions/disable",
                $options
            )
        );
    }

    /**
     * Enable production mode for an environment.
     *
     * @param  string $environmentUuid
     * @return OperationResponse
     */
    public function enableProductionMode($environmentUuid): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentUuid}/production-mode/actions/enable"
            )
        );
    }

    /**
     * Disable production mode for an environment.
     *
     * @param  string $environmentUuid
     * @return OperationResponse
     */
    public function disableProductionMode($environmentUuid): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentUuid}/production-mode/actions/disable"
            )
        );
    }

    /**
     * Add a new continuous delivery environment to an application.
     *
     * @param  string        $applicationUuid
     * @param  string        $label
     * @param  string        $branch
     * @param  array<string> $databases
     * @return OperationResponse
     */
    public function create($applicationUuid, $label, $branch, array $databases): OperationResponse
    {
        $options = [
            'json' => [
                'label' => $label,
                'branch' => $branch,
                'databases' => $databases,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'post',
                "/applications/${applicationUuid}/environments",
                $options
            )
        );
    }

    /**
     * Deletes a CD environment.
     *
     * @param  string $environmentUuid
     * @return OperationResponse
     */
    public function delete($environmentUuid): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'delete',
                "/environments/${environmentUuid}"
            )
        );
    }
}
