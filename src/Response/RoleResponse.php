<?php

namespace AcquiaCloudApi\Response;

class RoleResponse
{
    public string $uuid;

    public string $name;

    public string $description;

    public ?object $last_edited;

    /**
     * @var PermissionsResponse<PermissionResponse> $permissions
     */
    public PermissionsResponse $permissions;

    /**
     */
    public function __construct(object $role)
    {
        $this->uuid = $role->uuid;
        $this->name = $role->name;
        $this->description = $role->description;
        $this->last_edited = $role->last_edited;
        $this->permissions = new PermissionsResponse($role->permissions);
    }
}
