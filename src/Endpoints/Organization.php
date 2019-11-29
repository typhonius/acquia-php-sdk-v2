<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;
use AcquiaCloudApi\Response\ApplicationResponse;
use AcquiaCloudApi\Response\ApplicationsResponse;
use AcquiaCloudApi\Response\InvitationsResponse;
use AcquiaCloudApi\Response\MembersResponse;
use AcquiaCloudApi\Response\OrganizationsResponse;
use AcquiaCloudApi\Response\RolesResponse;
use AcquiaCloudApi\Response\TeamsResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Client
 * @package AcquiaCloudApi\CloudApi
 */
class Organization implements CloudApi
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
     * Show all organizations.
     *
     * @return OrganizationsResponse
     */
    public function getOrganizations()
    {
        return new OrganizationsResponse($this->client->request('get', '/organizations'));
    }

    /**
     * Show all applications in an organisation.
     *
     * @param string $organizationUuid
     *
     * @return ApplicationsResponse
     */
    public function getApplications($organizationUuid)
    {
        return new ApplicationsResponse(
            $this->client->request('get', "/organizations/${organizationUuid}/applications")
        );
    }

    /**
     * Show all roles in an organization.
     *
     * @param string $organizationUuid
     * @return RolesResponse
     */
    public function getRoles($organizationUuid)
    {
        return new RolesResponse(
            $this->client->request('get', "/organizations/${organizationUuid}/roles")
        );
    }

    /**
     * Create a new role.
     *
     * @param string      $organizationUuid
     * @param string      $name
     * @param array       $permissions
     * @param null|string $description
     * @return OperationResponse
     */
    public function createRole($organizationUuid, $name, array $permissions, $description = null)
    {
        $options = [
            'form_params' => [
                'name' => $name,
                'permissions' => $permissions,
                'description' => $description,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/organizations/${organizationUuid}/roles", $options)
        );
    }

    /**
     * Show all teams in an organization.
     *
     * @param string $organizationUuid
     * @return TeamsResponse
     */
    public function getTeams($organizationUuid)
    {
        return new TeamsResponse(
            $this->client->request('get', "/organizations/${organizationUuid}/teams")
        );
    }

    /**
     * Create a new team.
     *
     * @param string $organizationUuid
     * @param string $name
     * @return OperationResponse
     */
    public function createTeam($organizationUuid, $name)
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
     * Show all members of an organisation.
     *
     * @param string $organizationUuid
     * @return MembersResponse
     */
    public function getMembers($organizationUuid)
    {
        return new MembersResponse(
            $this->client->request('get', "/organizations/${organizationUuid}/members")
        );
    }

    /**
     * Show all members invited to an organisation.
     *
     * @param string $organizationUuid
     * @return InvitationsResponse
     */
    public function getInvitees($organizationUuid)
    {
        return new InvitationsResponse(
            $this->client->request('get', "/organizations/${organizationUuid}/team-invites")
        );
    }

    /**
     * Delete a member from an organisation.
     *
     * @param string $organizationUuid
     * @param string $memberUuid
     * @return OperationResponse
     */
    public function deleteMember($organizationUuid, $memberUuid)
    {
        return new OperationResponse(
            $this->client->request(
                'delete',
                "/organizations/${organizationUuid}/members/${memberUuid}"
            )
        );
    }
}
