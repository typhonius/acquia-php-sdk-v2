<?php

namespace AcquiaCloudApi\Response;

/**
 * @template TValue
 * @template-extends \ArrayObject<int,TValue>
 */
class PermissionsResponse extends \ArrayObject
{

    /**
     * @param array<object> $permissions
     */
    public function __construct($permissions)
    {
        parent::__construct(
            array_map(
                function ($permission) {
                    return new PermissionResponse($permission);
                },
                $permissions
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
