<?php

namespace AcquiaCloudApi\Response;

class OrganizationResponse
{
    public string $id;

    public string $uuid;

    public string $name;

    public MemberResponse $owner;

    public string $subscriptions_total;

    public string $admins_total;

    public string $users_total;

    public string $teams_total;

    public string $roles_total;

    public object $links;

    /**
     */
    public function __construct(object $organization)
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
