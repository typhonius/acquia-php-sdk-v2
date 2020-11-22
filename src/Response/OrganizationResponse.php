<?php

namespace AcquiaCloudApi\Response;

class OrganizationResponse extends GenericResponse
{
    /**
     * @var string $id
     */
    public $id;

    /**
     * @var string $uuid
     */
    public $uuid;

    /**
     * @var string $name
     */
    public $name;

    /**
     * @var object $owner
     */
    public $owner;

    /**
     * @var string $subscriptions_total
     */
    public $subscriptions_total;

    /**
     * @var string $admins_total
     */
    public $admins_total;

    /**
     * @var string $users_total
     */
    public $users_total;

    /**
     * @var string $teams_total
     */
    public $teams_total;

    /**
     * @var string $roles_total
     */
    public $roles_total;

    /**
     * @var object $links
     */
    public $links;

    /**
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
