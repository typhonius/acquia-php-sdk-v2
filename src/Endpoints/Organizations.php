<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\ApplicationResponse;
use AcquiaCloudApi\Response\ApplicationsResponse;
use AcquiaCloudApi\Response\InvitationResponse;
use AcquiaCloudApi\Response\InvitationsResponse;
use AcquiaCloudApi\Response\MemberResponse;
use AcquiaCloudApi\Response\MembersResponse;
use AcquiaCloudApi\Response\OperationResponse;
use AcquiaCloudApi\Response\OrganizationResponse;
use AcquiaCloudApi\Response\OrganizationsResponse;
use AcquiaCloudApi\Response\TeamResponse;
use AcquiaCloudApi\Response\TeamsResponse;

/**
 * Class Organizations
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Organizations extends CloudApiBase
{
    /**
     * Show all organizations.
     *
     * @return OrganizationsResponse<OrganizationResponse>
     */
    public function getAll(): OrganizationsResponse
    {
        return new OrganizationsResponse($this->client->request('get', '/organizations'));
    }

    /**
     * Show all applications in an organization.
     *
     * @param string $organizationUuid
     *
     * @return ApplicationsResponse<ApplicationResponse>
     */
    public function getApplications(string $organizationUuid): ApplicationsResponse
    {
        return new ApplicationsResponse(
            $this->client->request('get', "/organizations/$organizationUuid/applications")
        );
    }

    /**
     * Show all members of an organization.
     *
     * @param string $organizationUuid
     *
     * @return MembersResponse<MemberResponse>
     */
    public function getMembers(string $organizationUuid): MembersResponse
    {
        return new MembersResponse(
            $this->client->request('get', "/organizations/$organizationUuid/members")
        );
    }

    /**
     * Returns the user profile of this organization member.
     *
     * @param string $organizationUuid
     * @param string $memberUuid
     *
     * @return MemberResponse
     */
    public function getMember(string $organizationUuid, string $memberUuid): MemberResponse
    {
        return new MemberResponse(
            $this->client->request('get', "/organizations/$organizationUuid/members/$memberUuid")
        );
    }

    /**
     * Show all admins of an organization.
     *
     * @param string $organizationUuid
     *
     * @return MembersResponse<MemberResponse>
     */
    public function getAdmins(string $organizationUuid): MembersResponse
    {
        return new MembersResponse(
            $this->client->request('get', "/organizations/$organizationUuid/admins")
        );
    }

    /**
     * Returns the user profile of this organization administrator.
     *
     * @param string $organizationUuid
     * @param string $memberUuid
     *
     * @return MemberResponse
     */
    public function getAdmin(string $organizationUuid, string $memberUuid): MemberResponse
    {
        return new MemberResponse(
            $this->client->request('get', "/organizations/$organizationUuid/admins/$memberUuid")
        );
    }

    /**
     * Show all members invited to an organization.
     *
     * @param string $organizationUuid
     *
     * @return InvitationsResponse<InvitationResponse>
     */
    public function getMemberInvitations(string $organizationUuid): InvitationsResponse
    {
        return new InvitationsResponse(
            $this->client->request('get', "/organizations/$organizationUuid/team-invites")
        );
    }

    /**
     * Delete a member from an organization.
     *
     * @param string $organizationUuid
     * @param string $memberUuid
     *
     * @return OperationResponse
     */
    public function deleteMember(string $organizationUuid, string $memberUuid): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'delete',
                "/organizations/$organizationUuid/members/$memberUuid"
            )
        );
    }

    /**
     * Leave an organization.
     *
     * @param string $organizationUuid
     *
     * @return OperationResponse
     */
    public function leaveOrganization(string $organizationUuid): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/organizations/$organizationUuid/actions/leave"
            )
        );
    }

    /**
     * Change the owner of an organization.
     *
     * @param string $organizationUuid
     * @param string $newOwnerUuid
     *
     * @return OperationResponse
     */
    public function changeOwner(string $organizationUuid, string $newOwnerUuid): OperationResponse
    {
        $options = [
            'json' => [
                'user_uuid' => $newOwnerUuid,
            ],
        ];
        return new OperationResponse(
            $this->client->request(
                'post',
                "/organizations/$organizationUuid/actions/change-owner",
                $options
            )
        );
    }

    /**
     * Show all teams in an organization.
     *
     * @param string $organizationUuid
     *
     * @return TeamsResponse<TeamResponse>
     */
    public function getTeams(string $organizationUuid): TeamsResponse
    {
        return new TeamsResponse(
            $this->client->request('get', "/organizations/$organizationUuid/teams")
        );
    }

    /**
     * Invites a user to become admin of an organization.
     *
     * @param string $organizationUuid
     * @param string $email
     *
     * @return OperationResponse
     */
    public function inviteAdmin(string $organizationUuid, string $email): OperationResponse
    {
        $options = [
            'json' => [
                'email' => $email,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/organizations/$organizationUuid/admin-invites", $options)
        );
    }
}
