<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;
use AcquiaCloudApi\Response\ApplicationResponse;
use AcquiaCloudApi\Response\ApplicationsResponse;
use AcquiaCloudApi\Response\TeamsResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Client
 * @package AcquiaCloudApi\CloudApi
 */
class Teams implements CloudApi
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
     * Create a new team.
     *
     * @param string $organizationUuid
     * @param string $name
     * @return OperationResponse
     */
    public function create($organizationUuid, $name)
    {
        $options = [
            'form_params' => [
                'name' => $name,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/organizations/${organizationUuid}/teams", $options)
        );
    }

    /**
     * Show all teams.
     *
     * @return TeamsResponse
     */
    public function getAll()
    {
        return new TeamsResponse(
            $this->client->request('get', '/teams')
        );
    }

    /**
     * Rename an existing team.
     *
     * @param string $teamUuid
     * @param string $name
     * @return OperationResponse
     */
    public function rename($teamUuid, $name)
    {
        $options = [
            'form_params' => [
                'name' => $name,
            ],
        ];

        return new OperationResponse(
            $this->client->request('put', "/teams/${teamUuid}", $options)
        );
    }


    /**
     * Delete a team.
     *
     * @param string $teamUuid
     * @return OperationResponse
     */
    public function delete($teamUuid)
    {
        return new OperationResponse(
            $this->client->request('delete', "/teams/${teamUuid}")
        );
    }

    /**
     * Add an application to a team.
     *
     * @param string $teamUuid
     * @param string $applicationUuid
     * @return OperationResponse
     */
    public function addApplication($teamUuid, $applicationUuid)
    {
        $options = [
            'form_params' => [
                'uuid' => $applicationUuid,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/teams/${teamUuid}/applications", $options)
        );
    }

    /**
     * Invites a user to join a team.
     *
     * @param string $teamUuid
     * @param string $email
     * @param array  $roles
     * @return OperationResponse
     */
    public function createTeamInvite($teamUuid, $email, $roles)
    {
        $options = [
            'form_params' => [
                'email' => $email,
                'roles' => $roles
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/teams/${teamUuid}/invites", $options)
        );
    }

    /**
     * Invites a user to become admin of an organization.
     *
     * @param string $organizationUuid
     * @param string $email
     * @return OperationResponse
     */
    public function createOrganizationAdminInvite($organizationUuid, $email)
    {
        $options = [
            'form_params' => [
                'email' => $email,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/teams/${organizationUuid}/invites", $options)
        );
    }

    /**
     * Show all applications associated with a team.
     *
     * @param string $teamUuid
     * @return ApplicationsResponse
     */
    public function getApplications($teamUuid)
    {
        return new ApplicationsResponse(
            $this->client->request('get', "/teams/${teamUuid}/applications")
        );
    }
}
