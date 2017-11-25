<?php

namespace AcquiaCloudApi\Response;

/**
 * Class RolesResponse
 * @package AcquiaCloudApi\Response
 */
class RolesResponse extends \ArrayObject
{

    /**
     * RolesResponse constructor.
     * @param array $roles
     */
    public function __construct($roles)
    {
        parent::__construct(array_map(function ($role) {
            return new RoleResponse($role);
        }, $roles), self::ARRAY_AS_PROPS);
    }
}
