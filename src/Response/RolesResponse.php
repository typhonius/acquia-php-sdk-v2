<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<RoleResponse>
 */
class RolesResponse extends CollectionResponse
{

    /**
     * @param array<object> $roles
     */
    public function __construct($roles)
    {
        parent::__construct('RoleResponse', $roles);
    }
}
