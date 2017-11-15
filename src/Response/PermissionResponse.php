<?php

namespace AcquiaCloudApi\Response;

/**
 * Class PermissionResponse
 * @package AcquiaCloudApi\Response
 */
class PermissionResponse
{
    public $name;
    public $label;
    public $description;
    public $group_label;

    /**
     * PermissionResponse constructor.
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
