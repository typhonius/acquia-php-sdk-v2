<?php

namespace AcquiaCloudApi\Response;

class PermissionResponse
{
    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $label
     */
    public $label;

    /**
     * @var string|null $description
     */
    public $description;

    /**
     * @var string $group_label
     */
    public $group_label;

    /**
     * @param object $permission
     */
    public function __construct($permission)
    {
        $this->name = $permission->name;
        $this->label = $permission->label;
        $this->description = $permission->description;
        $this->group_label = $permission->group_label;
    }
}
