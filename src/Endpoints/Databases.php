<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;
use AcquiaCloudApi\Response\DatabasesResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Client
 * @package AcquiaCloudApi\CloudApi
 */
class Databases implements CloudApi
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
     * Shows all databases in an application.
     *
     * @param string $applicationUuid
     * @return DatabasesResponse
     */
    public function getAll($applicationUuid)
    {
        return new DatabasesResponse(
            $this->client->request(
                'get',
                "/applications/${applicationUuid}/databases"
            )
        );
    }

    /**
     * Create a new database.
     *
     * @param string $applicationUuid
     * @param string $name
     * @return OperationResponse
     */
    public function create($applicationUuid, $name)
    {
        $options = [
            'form_params' => [
                'name' => $name,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/applications/${applicationUuid}/databases", $options)
        );
    }

    /**
     * Delete a database.
     *
     * @param string $applicationUuid
     * @param string $name
     * @return OperationResponse
     */
    public function delete($applicationUuid, $name)
    {
        return new OperationResponse(
            $this->client->request('delete', "/applications/${applicationUuid}/databases/${name}")
        );
    }

    /**
     * Copies a database from an environment to an environment.
     *
     * @param string $environmentFromUuid
     * @param string $dbName
     * @param string $environmentToUuid
     * @return OperationResponse
     */
    public function copy($environmentFromUuid, $dbName, $environmentToUuid)
    {
        $options = [
            'form_params' => [
                'name' => $dbName,
                'source' => $environmentFromUuid,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/environments/${environmentToUuid}/databases", $options)
        );
    }
}
