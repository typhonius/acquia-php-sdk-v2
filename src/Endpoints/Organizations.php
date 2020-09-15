<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\ApplicationsResponse;
use AcquiaCloudApi\Response\InvitationsResponse;
use AcquiaCloudApi\Response\MembersResponse;
use AcquiaCloudApi\Response\MemberResponse;
use AcquiaCloudApi\Response\OrganizationsResponse;
use AcquiaCloudApi\Response\TeamsResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Organizations
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Organizations extends CloudApiBase implements CloudApiInterface
{

    /**
     * Show all organizations.
     *
     * @return OrganizationsResponse
     */
    public function getAll()
    {
        return new OrganizationsResponse($this->client->request('get', '/organizations'));
    }

    /**
     * Show all applications in an organization.
     *
     * @param string $organizationUuid
     * @return ApplicationsResponse
     */
    public function getApplications($organizationUuid)
    {
        return new ApplicationsResponse(
            $this->client->request('get', "/organizations/${organizationUuid}/applications")
        );
    }

    /**
     * Show all members of an organization.
     *
     * @param  string $organizationUuid
     * @return MembersResponse
     */
    public function getMembers($organizationUuid)
    {
        return new MembersResponse(
            $this->client->request('get', "/organizations/${organizationUuid}/members")
        );
    }

    /**
     * Returns the user profile of this organization member.
     *
     * @param  string $organizationUuid
     * @param  string $memberUuid
     * @return MemberResponse
     */
    public function getMember($organizationUuid, $memberUuid)
    {
        return new MemberResponse(
            $this->client->request('get', "/organizations/${organizationUuid}/members/${memberUuid}")
        );
    }

    /**
     * Show all admins of an organization.
     *
     * @param  string $organizationUuid
     * @return MembersResponse
     */
    public function getAdmins($organizationUuid)
    {
        return new MembersResponse(
            $this->client->request('get', "/organizations/${organizationUuid}/admins")
        );
    }

    /**
     * Returns the user profile of this organization administrator.
     *
     * @param  string $organizationUuid
     * @param  string $memberUuid
     * @return MemberResponse
     */
    public function getAdmin($organizationUuid, $memberUuid)
    {
        return new MemberResponse(
            $this->client->request('get', "/organizations/${organizationUuid}/admins/${memberUuid}")
        );
    }

    /**
     * Show all members invited to an organization.
     *
     * @param  string $organizationUuid
     * @return InvitationsResponse
     */
    public function getMemberInvitations($organizationUuid)
    {
        return new InvitationsResponse(
            $this->client->request('get', "/organizations/${organizationUuid}/team-invites")
        );
    }

    /**
     * Delete a member from an organization.
     *
     * @param  string $organizationUuid
     * @param  string $memberUuid
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

    /**
     * Leave an organization.
     *
     * @param string $organizationUuid
     * @return OperationResponse
     */
    public function leaveOrganization($organizationUuid)
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/organizations/${organizationUuid}/actions/leave"
            )
        );
    }

    /**
     * Change the owner of an organization.
     *
     * @param string $organizationUuid
     * @param string $newOwnerUuid
     * @return OperationResponse
     */
    public function changeOwner($organizationUuid, $newOwnerUuid)
    {
        $options = [
            'json' => [
                'user_uuid' => $newOwnerUuid,
            ],
        ];
        return new OperationResponse(
            $this->client->request(
                'post',
                "/organizations/${organizationUuid}/actions/change-owner",
                $options
            )
        );
    }

    /**
     * Show all teams in an organization.
     *
     * @param  string $organizationUuid
     * @return TeamsResponse
     */
    public function getTeams($organizationUuid)
    {
        return new TeamsResponse(
            $this->client->request('get', "/organizations/${organizationUuid}/teams")
        );
    }

    /**
     * Invites a user to become admin of an organization.
     *
     * @param  string $organizationUuid
     * @param  string $email
     * @return OperationResponse
     */
    public function inviteAdmin($organizationUuid, $email)
    {
        $options = [
            'json' => [
                'email' => $email,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/organizations/${organizationUuid}/admin-invites", $options)
        );
    }
}
