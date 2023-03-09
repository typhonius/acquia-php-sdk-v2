<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\RoleResponse>
 */
class RolesResponse extends \ArrayObject
{
    /**
     * @param array<object> $roles
     */
    public function __construct(array $roles)
    {
        parent::__construct(
            array_map(
                static function ($role) {
                    return new RoleResponse($role);
                },
                $roles
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
