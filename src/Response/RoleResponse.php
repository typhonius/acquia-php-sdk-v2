<?php

namespace AcquiaCloudApi\Response;

/**
 * Class RoleResponse
 * @package AcquiaCloudApi\Response
 */
class RoleResponse
{
    public $uuid;
    public $name;
    public $description;
    public $last_edited;
    public $permissions;

    /**
     * RoleResponse constructor.
     * @param object $role
     */
    public function __construct($role)
    {
        $this->uuid = $role->uuid;
        $this->name = $role->name;
        $this->description = $role->description;
        $this->last_edited = $role->last_edited;
        $this->permissions = new PermissionsResponse($role->permissions);
    }
}
