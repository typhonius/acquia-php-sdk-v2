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
class Environments extends CloudApiBase
{
    /**
     * Copies files from an environment to another environment.
     *
     *
     */
    public function copyFiles(string $environmentUuidFrom, string $environmentUuidTo): OperationResponse
    {
        $options = [
            'json' => [
                'source' => $environmentUuidFrom,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/environments/$environmentUuidTo/files", $options)
        );
    }

    /**
     * Gets information about an environment.
     *
     *
     */
    public function get(string $environmentUuid): EnvironmentResponse
    {
        return new EnvironmentResponse(
            $this->client->request(
                'get',
                "/environments/$environmentUuid"
            )
        );
    }

    /**
     * Shows all environments in an application.
     *
     *
     * @return EnvironmentsResponse<EnvironmentResponse>
     */
    public function getAll(string $applicationUuid): EnvironmentsResponse
    {
        return new EnvironmentsResponse(
            $this->client->request(
                'get',
                "/applications/$applicationUuid/environments"
            )
        );
    }

    /**
     * Modifies configuration settings for an environment.
     *
     * @param mixed[] $config
     *
     */
    public function update(string $environmentUuid, array $config): OperationResponse
    {

        $options = [
            'json' => $config,
        ];

        return new OperationResponse(
            $this->client->request(
                'put',
                "/environments/$environmentUuid",
                $options
            )
        );
    }

    /**
     * Renames an environment.
     *
     *
     */
    public function rename(string $environmentUuid, string $label): OperationResponse
    {

        $options = [
            'json' => [
                'label' => $label,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/$environmentUuid/actions/change-label",
                $options
            )
        );
    }

    /**
     * Enable livedev mode for an environment.
     *
     *
     */
    public function enableLiveDev(string $environmentUuid): OperationResponse
    {
        return new OperationResponse(
            $this->client->request('post', "/environments/$environmentUuid/livedev/actions/enable")
        );
    }

    /**
     * Disable livedev mode for an environment.
     *
     *
     */
    public function disableLiveDev(string $environmentUuid): OperationResponse
    {

        $options = [
            'json' => [
                'discard' => 1,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/$environmentUuid/livedev/actions/disable",
                $options
            )
        );
    }

    /**
     * Enable production mode for an environment.
     *
     *
     */
    public function enableProductionMode(string $environmentUuid): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/$environmentUuid/production-mode/actions/enable"
            )
        );
    }

    /**
     * Disable production mode for an environment.
     *
     *
     */
    public function disableProductionMode(string $environmentUuid): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/$environmentUuid/production-mode/actions/disable"
            )
        );
    }

    /**
     * Enable platform email for an environment.
     *
     *
     */
    public function enableEmail(string $environmentUuid): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/$environmentUuid/email/actions/enable"
            )
        );
    }

    /**
     * Disable platform email for an environment.
     *
     *
     */
    public function disableEmail(string $environmentUuid): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/$environmentUuid/email/actions/disable"
            )
        );
    }

    /**
     * Add a new continuous delivery environment to an application.
     *
     * @param array<string> $databases
     *
     */
    public function create(string $applicationUuid, string $label, string $branch, array $databases): OperationResponse
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
                "/applications/$applicationUuid/environments",
                $options
            )
        );
    }

    /**
     * Deletes a CD environment.
     *
     *
     */
    public function delete(string $environmentUuid): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'delete',
                "/environments/$environmentUuid"
            )
        );
    }
}
