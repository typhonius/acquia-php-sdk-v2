<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;
use AcquiaCloudApi\Response\ApplicationResponse;
use AcquiaCloudApi\Response\ApplicationsResponse;
use AcquiaCloudApi\Response\DatabasesResponse;
use AcquiaCloudApi\Response\BranchesResponse;
use AcquiaCloudApi\Response\EnvironmentsResponse;
use AcquiaCloudApi\Response\InsightsResponse;
use AcquiaCloudApi\Response\TasksResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Client
 * @package AcquiaCloudApi\CloudApi
 */
class Application implements CloudApi
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
     * Shows all applications.
     *
     * @return ApplicationsResponse
     */
    public function getApplications()
    {
        return new ApplicationsResponse($this->client->request('get', '/applications'));
    }

    /**
     * Shows information about an application.
     *
     * @param string $applicationUuid
     * @return ApplicationResponse
     */
    public function getApplication($applicationUuid)
    {
        return new ApplicationResponse(
            $this->client->request(
                'get',
                "/applications/${applicationUuid}"
            )
        );
    }

    /**
     * Renames an application.
     *
     * @param string $applicationUuid
     * @param string $name
     * @return OperationResponse
     */
    public function renameApplication($applicationUuid, $name)
    {

        $options = [
            'form_params' => [
                'name' => $name,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'put',
                "/applications/${applicationUuid}",
                $options
            )
        );
    }

    /**
     * Shows all code branches and tags in an application.
     *
     * @param string $applicationUuid
     * @return BranchesResponse
     */
    public function getBranches($applicationUuid)
    {
        return new BranchesResponse(
            $this->client->request(
                'get',
                "/applications/${applicationUuid}/code"
            )
        );
    }

    /**
     * Shows all databases in an application.
     *
     * @param string $applicationUuid
     * @return DatabasesResponse
     */
    public function getDatabases($applicationUuid)
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
    public function createDatabase($applicationUuid, $name)
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
    public function deleteDatabase($applicationUuid, $name)
    {
        return new OperationResponse(
            $this->client->request('delete', "/applications/${applicationUuid}/databases/${name}")
        );
    }

    /**
     * Shows all tasks in an application.
     *
     * @param string $applicationUuid
     * @return TasksResponse
     */
    public function getTasks($applicationUuid)
    {
        return new TasksResponse(
            $this->client->request(
                'get',
                "/applications/${applicationUuid}/tasks"
            )
        );
    }

    /**
     * Shows all environments in an application.
     *
     * @param string $applicationUuid
     * @return EnvironmentsResponse
     */
    public function getEnvironments($applicationUuid)
    {
        return new EnvironmentsResponse(
            $this->client->request(
                'get',
                "/applications/${applicationUuid}/environments"
            )
        );
    }

    /**
     * Show insights data from an application.
     *
     * @param string $applicationUuid
     * @return InsightsResponse
     */
    public function getInsights($applicationUuid)
    {
        return new InsightsResponse(
            $this->client->request('get', "/applications/${applicationUuid}/insight")
        );
    }
}
