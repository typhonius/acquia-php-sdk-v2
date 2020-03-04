<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;
use AcquiaCloudApi\Response\EnvironmentResponse;
use AcquiaCloudApi\Response\EnvironmentsResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Environments
 * @package AcquiaCloudApi\CloudApi
 */
class Environments extends CloudApiBase implements CloudApiInterface
{

    /**
     * Copies files from an environment to another environment.
     *
     * @param string $environmentUuidFrom
     * @param string $environmentUuidTo
     * @return OperationResponse
     */
    public function copyFiles($environmentUuidFrom, $environmentUuidTo)
    {

        $this->client->addOption('form_params', ['source' => $environmentUuidFrom]);

        return new OperationResponse(
            $this->client->request('post', "/environments/${environmentUuidTo}/files")
        );
    }

    /**
     * Gets information about an environment.
     *
     * @param string $environmentUuid
     * @return EnvironmentResponse
     */
    public function get($environmentUuid)
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
     * @param string $applicationUuid
     * @return EnvironmentsResponse
     */
    public function getAll($applicationUuid)
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
     * @param string $environmentUuid
     * @param array $config
     * @return OperationResponse
     */
    public function update($environmentUuid, array $config)
    {

        $this->client->addOption('form_params', $config);

        return new OperationResponse(
            $this->client->request(
                'put',
                "/environments/${environmentUuid}"
            )
        );
    }

    /**
     * Renames an environment.
     *
     * @param string $environmentUuid
     * @param string $label
     * @return OperationResponse
     */
    public function rename($environmentUuid, $label)
    {

        $this->client->addOption('form_params', ['label' => $label]);

        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentUuid}/actions/change-label"
            )
        );
    }

    /**
     * Enable livedev mode for an environment.
     *
     * @param string $environmentUuid
     * @return OperationResponse
     */
    public function enableLiveDev($environmentUuid)
    {
        return new OperationResponse(
            $this->client->request('post', "/environments/${environmentUuid}/livedev/actions/enable")
        );
    }

    /**
     * Disable livedev mode for an environment.
     *
     * @param string $environmentUuid
     * @return OperationResponse
     */
    public function disableLiveDev($environmentUuid)
    {

        $this->client->addOption('form_params', ['discard' => 1]);

        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentUuid}/livedev/actions/disable"
            )
        );
    }

    /**
     * Enable production mode for an environment.
     *
     * @param string $environmentUuid
     * @return OperationResponse
     */
    public function enableProductionMode($environmentUuid)
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
     * @param string $environmentUuid
     * @return OperationResponse
     */
    public function disableProductionMode($environmentUuid)
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
     * @param string $applicationUuid
     * @param string $label
     * @param string $branch
     * @param array  $databases
     * @return OperationResponse
     */
    public function create($applicationUuid, $label, $branch, array $databases)
    {
        $params = [
            'label' => $label,
            'branch' => $branch,
            'databases' => $databases,
        ];
        $this->client->addOption('form_params', $params);

        return new OperationResponse(
            $this->client->request(
                'post',
                "/applications/${applicationUuid}/environments"
            )
        );
    }

    /**
     * Deletes a CD environment.
     *
     * @param string $environmentUuid
     * @return OperationResponse
     */
    public function delete($environmentUuid)
    {
        return new OperationResponse(
            $this->client->request(
                'delete',
                "/environments/${environmentUuid}"
            )
        );
    }
}
