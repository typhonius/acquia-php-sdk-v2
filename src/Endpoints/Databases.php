<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\DatabaseResponse;
use AcquiaCloudApi\Response\DatabasesResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Databases
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Databases extends CloudApiBase
{
    /**
     * Shows all databases in an application.
     *
     * @param string $applicationUuid
     *
     * @return DatabasesResponse<DatabaseResponse>
     */
    public function getAll(string $applicationUuid): DatabasesResponse
    {
        return new DatabasesResponse(
            $this->client->request(
                'get',
                "/applications/$applicationUuid/databases"
            )
        );
    }

    /**
     * Create a new database.
     *
     * @param string $applicationUuid
     * @param string $name
     *
     * @return OperationResponse
     */
    public function create(string $applicationUuid, string $name): OperationResponse
    {
        $options = [
            'json' => [
                'name' => $name,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/applications/$applicationUuid/databases", $options)
        );
    }

    /**
     * Delete a database.
     *
     * @param string $applicationUuid
     * @param string $name
     *
     * @return OperationResponse
     */
    public function delete(string $applicationUuid, string $name): OperationResponse
    {
        return new OperationResponse(
            $this->client->request('delete', "/applications/$applicationUuid/databases/$name")
        );
    }

    /**
     * Erases (truncates) a database.
     *
     * This action will delete all tables of the database in ALL environments
     * within this application.
     *
     * @param string $applicationUuid
     * @param string $name
     *
     * @return OperationResponse
     */
    public function truncate(string $applicationUuid, string $name): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/applications/$applicationUuid/databases/$name/actions/erase"
            )
        );
    }

    /**
     * Copies a database from an environment to an environment.
     *
     * @param string $environmentFromUuid
     * @param string $dbName
     * @param string $environmentToUuid
     *
     * @return OperationResponse
     */
    public function copy(string $environmentFromUuid, string $dbName, string $environmentToUuid): OperationResponse
    {
        $options = [
            'json' => [
                'name' => $dbName,
                'source' => $environmentFromUuid,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/environments/$environmentToUuid/databases", $options)
        );
    }
}
