<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\ApplicationResponse;
use AcquiaCloudApi\Response\ApplicationsResponse;
use AcquiaCloudApi\Response\OperationResponse;
use AcquiaCloudApi\Response\TeamResponse;
use AcquiaCloudApi\Response\TeamsResponse;

/**
 * Class Teams
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Teams extends CloudApiBase
{
    /**
     * Create a new team.
     *
     *
     */
    public function create(string $organizationUuid, string $name): OperationResponse
    {
        $options = [
            'json' => [
                'name' => $name,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/organizations/$organizationUuid/teams", $options)
        );
    }

    /**
     * Show all teams.
     *
     * @return TeamsResponse<TeamResponse>
     */
    public function getAll(): TeamsResponse
    {
        return new TeamsResponse(
            $this->client->request('get', '/teams')
        );
    }

    /**
     * Rename an existing team.
     *
     *
     */
    public function rename(string $teamUuid, string $name): OperationResponse
    {
        $options = [
            'json' => [
                'name' => $name,
            ],
        ];

        return new OperationResponse(
            $this->client->request('put', "/teams/$teamUuid", $options)
        );
    }


    /**
     * Delete a team.
     *
     *
     */
    public function delete(string $teamUuid): OperationResponse
    {
        return new OperationResponse(
            $this->client->request('delete', "/teams/$teamUuid")
        );
    }

    /**
     * Add an application to a team.
     *
     *
     */
    public function addApplication(string $teamUuid, string $applicationUuid): OperationResponse
    {
        $options = [
            'json' => [
                'uuid' => $applicationUuid,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/teams/$teamUuid/applications", $options)
        );
    }

    /**
     * Invites a user to join a team.
     *
     * @param string[] $roles
     *
     */
    public function invite(string $teamUuid, string $email, array $roles): OperationResponse
    {
        $options = [
            'json' => [
                'email' => $email,
                'roles' => $roles,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/teams/$teamUuid/invites", $options)
        );
    }

    /**
     * Show all applications associated with a team.
     *
     *
     * @return ApplicationsResponse<ApplicationResponse>
     */
    public function getApplications(string $teamUuid): ApplicationsResponse
    {
        return new ApplicationsResponse(
            $this->client->request('get', "/teams/$teamUuid/applications")
        );
    }
}
