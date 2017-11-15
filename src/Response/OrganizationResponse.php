<?php

namespace AcquiaCloudApi\Response;

/**
 * Class OrganizationResponse
 * @package AcquiaCloudApi\Response
 */
class OrganizationResponse
{
    public $id;
    public $uuid;
    public $name;
    public $owner;
    public $subscriptions_total;
    public $admins_total;
    public $users_total;
    public $teams_total;
    public $roles_total;
    public $links;

    /**
     * OrganizationResponse constructor.
     * @param object $organization
     */
    public function __construct($organization)
    {
        $this->id = $organization->id;
        $this->uuid = $organization->uuid;
        $this->name = $organization->name;
        $this->owner = new MemberResponse($organization->owner);
        $this->subscriptions_total = $organization->subscriptions_total;
        $this->admins_total = $organization->admins_total;
        $this->users_total = $organization->users_total;
        $this->teams_total = $organization->teams_total;
        $this->roles_total = $organization->roles_total;
        $this->links = $organization->_links;
    }
}
