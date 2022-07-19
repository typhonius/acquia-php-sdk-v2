<?php

namespace AcquiaCloudApi\Response;

class RoleResponse extends GenericResponse
{
    /**
     * @var string $uuid
     */
    public $uuid;

    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $description
     */
    public $description;

    /**
     * @var string $last_edited
     */
    public $last_edited;

    /**
     * @var PermissionsResponse<PermissionResponse> $permissions
     */
    public $permissions;

    /**
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
