<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\PermissionResponse>
 */
class PermissionsResponse extends \ArrayObject
{
    /**
     * @param array<object> $permissions
     */
    public function __construct(array $permissions)
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
