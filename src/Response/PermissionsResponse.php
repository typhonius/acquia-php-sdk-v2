<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<PermissionResponse>
 */
class PermissionsResponse extends CollectionResponse
{

    /**
     * @param array<object> $permissions
     */
    public function __construct($permissions)
    {
        parent::__construct('PermissionResponse', $permissions);
    }
}
