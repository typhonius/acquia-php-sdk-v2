<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\ApplicationResponse;
use AcquiaCloudApi\Response\ApplicationsResponse;
use AcquiaCloudApi\Response\TeamsResponse;
use AcquiaCloudApi\Response\TeamResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Teams
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Teams extends CloudApiBase implements CloudApiInterface
{
    /**
     * Create a new team.
     *
     * @param  string $organizationUuid
     * @param  string $name
     * @return OperationResponse
     */
    public function create($organizationUuid, $name): OperationResponse
    {
        $options = [
            'json' => [
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
     * @param  string $teamUuid
     * @param  string $name
     * @return OperationResponse
     */
    public function rename($teamUuid, $name): OperationResponse
    {
        $options = [
            'json' => [
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
     * @param  string $teamUuid
     * @return OperationResponse
     */
    public function delete($teamUuid): OperationResponse
    {
        return new OperationResponse(
            $this->client->request('delete', "/teams/${teamUuid}")
        );
    }

    /**
     * Add an application to a team.
     *
     * @param  string $teamUuid
     * @param  string $applicationUuid
     * @return OperationResponse
     */
    public function addApplication($teamUuid, $applicationUuid): OperationResponse
    {
        $options = [
            'json' => [
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
     * @param  string   $teamUuid
     * @param  string   $email
     * @param  string[] $roles
     * @return OperationResponse
     */
    public function invite($teamUuid, $email, $roles): OperationResponse
    {
        $options = [
            'json' => [
                'email' => $email,
                'roles' => $roles
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/teams/${teamUuid}/invites", $options)
        );
    }

    /**
     * Show all applications associated with a team.
     *
     * @param  string $teamUuid
     * @return ApplicationsResponse<ApplicationResponse>
     */
    public function getApplications($teamUuid): ApplicationsResponse
    {
        return new ApplicationsResponse(
            $this->client->request('get', "/teams/${teamUuid}/applications")
        );
    }
}
