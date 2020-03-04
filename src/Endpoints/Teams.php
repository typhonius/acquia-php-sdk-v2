<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;
use AcquiaCloudApi\Response\ApplicationResponse;
use AcquiaCloudApi\Response\ApplicationsResponse;
use AcquiaCloudApi\Response\TeamsResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Teams
 * @package AcquiaCloudApi\CloudApi
 */
class Teams extends CloudApiBase implements CloudApiInterface
{

    /**
     * Create a new team.
     *
     * @param string $organizationUuid
     * @param string $name
     * @return OperationResponse
     */
    public function create($organizationUuid, $name)
    {

        $this->client->addOption('form_params', ['name' => $name]);

        return new OperationResponse(
            $this->client->request('post', "/organizations/${organizationUuid}/teams")
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

        $this->client->addOption('form_params', ['name' => $name]);

        return new OperationResponse(
            $this->client->request('put', "/teams/${teamUuid}")
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

        $this->client->addOption('form_params', ['uuid' => $applicationUuid]);

        return new OperationResponse(
            $this->client->request('post', "/teams/${teamUuid}/applications")
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
    public function invite($teamUuid, $email, $roles)
    {
        $params = [
            'email' => $email,
            'roles' => $roles
        ];
        $this->client->addOption('form_params', $params);

        return new OperationResponse(
            $this->client->request('post', "/teams/${teamUuid}/invites")
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
