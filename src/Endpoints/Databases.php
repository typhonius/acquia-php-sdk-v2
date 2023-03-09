<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\DatabaseNameResponse;
use AcquiaCloudApi\Response\DatabaseNamesResponse;
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
     *
     * @return DatabaseNamesResponse<DatabaseNameResponse>
     */
    public function getNames(string $applicationUuid): DatabaseNamesResponse
    {
        return new DatabaseNamesResponse(
            $this->client->request(
                'get',
                "/applications/$applicationUuid/databases"
            )
        );
    }

    /**
     * Shows all databases in an environment.
     */
    public function getAll(string $environmentUuid): DatabasesResponse
    {
        return new DatabasesResponse(
            $this->client->request(
                'get',
                "/environments/$environmentUuid/databases"
            )
        );
    }

    /**
     * Create a new database.
     *
     *
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
     *
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
     *
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
     *
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
