<?php

namespace AcquiaCloudApi\Response;

class PermissionResponse
{
    public string $name;

    public string $label;

    public ?string $description;

    public string $group_label;

    /**
     */
    public function __construct(object $permission)
    {
        $this->name = $permission->name;
        $this->label = $permission->label;
        $this->description = $permission->description;
        $this->group_label = $permission->group_label;
    }
}
