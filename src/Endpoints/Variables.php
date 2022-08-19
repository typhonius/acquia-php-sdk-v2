<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\OperationResponse;
use AcquiaCloudApi\Response\VariableResponse;
use AcquiaCloudApi\Response\VariablesResponse;

/**
 * Class Variables
 *
 * @package AcquiaCloudApi\Endpoints
 */
class Variables extends CloudApiBase
{
    /**
     * Fetches all environment variables.
     *
     * @param string $environmentUuid
     *
     * @return VariablesResponse<VariableResponse>
     */
    public function getAll(string $environmentUuid): VariablesResponse
    {
        return new VariablesResponse(
            $this->client->request(
                'get',
                "/environments/$environmentUuid/variables"
            )
        );
    }

    /**
     * Returns details about an environment variable.
     *
     * @param string $environmentUuid
     * @param string $name
     *
     * @return VariableResponse
     */
    public function get(string $environmentUuid, string $name): VariableResponse
    {
        return new VariableResponse(
            $this->client->request(
                'get',
                "/environments/$environmentUuid/variables/$name"
            )
        );
    }

    /**
     * Adds an environment variable.
     *
     * @param string $environmentUuid
     * @param string $name
     * @param string $value
     *
     * @return OperationResponse
     */
    public function create(string $environmentUuid, string $name, string $value): OperationResponse
    {
        $options = [
            'json' => [
                'name' => $name,
                'value' => $value,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/environments/$environmentUuid/variables", $options)
        );
    }

    /**
     * Updates an environment variable.
     *
     * @param string $environmentUuid
     * @param string $name
     * @param string $value
     *
     * @return OperationResponse
     */
    public function update(string $environmentUuid, string $name, string $value): OperationResponse
    {
        $options = [
            'json' => [
                'name' => $name,
                'value' => $value,
            ],
        ];

        return new OperationResponse(
            $this->client->request('put', "/environments/$environmentUuid/variables/$name", $options)
        );
    }

    /**
     * Deletes an environment variable.
     *
     * @param string $environmentUuid
     * @param string $name
     *
     * @return OperationResponse
     */
    public function delete(string $environmentUuid, string $name): OperationResponse
    {
        return new OperationResponse(
            $this->client->request('delete', "/environments/$environmentUuid/variables/$name")
        );
    }
}
