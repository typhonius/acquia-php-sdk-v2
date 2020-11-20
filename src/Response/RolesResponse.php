<?php

namespace AcquiaCloudApi\Response;

/**
 * @template TValue
 * @template-extends \ArrayObject<int,TValue>
 */
class RolesResponse extends \ArrayObject
{

    /**
     * @param array<object> $roles
     */
    public function __construct($roles)
    {
        parent::__construct(
            array_map(
                function ($role) {
                    return new RoleResponse($role);
                },
                $roles
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
