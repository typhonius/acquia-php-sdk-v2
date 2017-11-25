<?php

namespace AcquiaCloudApi\Response;

/**
 * Class PermissionsResponse
 * @package AcquiaCloudApi\Response
 */
class PermissionsResponse extends \ArrayObject
{

    /**
     * PermissionsResponse constructor.
     * @param array $permissions
     */
    public function __construct($permissions)
    {
        parent::__construct(array_map(function ($permission) {
            return new PermissionResponse($permission);
        }, $permissions), self::ARRAY_AS_PROPS);
    }
}
