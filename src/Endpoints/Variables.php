<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\OperationResponse;
use AcquiaCloudApi\Response\VariableResponse;
use AcquiaCloudApi\Response\VariablesResponse;

/**
 * Class Variables
 * @package AcquiaCloudApi\Endpoints
 */
class Variables extends CloudApiBase implements CloudApiInterface
{

    /**
     * Fetches all environment variables.
     *
     * @param string $environmentUuid
     * @return VariablesResponse
     */
    public function getAll($environmentUuid)
    {
        return new VariablesResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/variables"
            )
        );
    }

    /**
     * Returns details about an environment variable.
     *
     * @param string $environmentUuid
     * @param string $name
     * @return VariableResponse
     */
    public function get($environmentUuid, $name)
    {
        return new VariableResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/variables/${name}"
            )
        );
    }

    /**
     * Adds an environment variable.
     *
     * @param string $environmentUuid
     * @param string $name
     * @param string $value
     * @return OperationResponse
     */
    public function create($environmentUuid, $name, $value)
    {
        $params = [
            'name' => $name,
            'value' => $value,
        ];
        $this->client->addOption('form_params', $params);

        return new OperationResponse(
            $this->client->request('post', "/environments/${environmentUuid}/variables")
        );
    }

    /**
     * Updates an environment variable.
     *
     * @param string $environmentUuid
     * @param string $name
     * @param string $value
     * @return OperationResponse
     */
    public function update($environmentUuid, $name, $value)
    {
        $params = [
            'name' => $name,
            'value' => $value,
        ];
        $this->client->addOption('form_params', $params);

        return new OperationResponse(
            $this->client->request('put', "/environments/${environmentUuid}/variables/${name}")
        );
    }

    /**
     * Deletes an environment variable.
     *
     * @param string $environmentUuid
     * @param string $name
     * @return OperationResponse
     */
    public function delete($environmentUuid, $name)
    {
        return new OperationResponse(
            $this->client->request('delete', "/environments/${environmentUuid}/variables/${name}")
        );
    }
}
