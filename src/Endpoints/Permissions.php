<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\PermissionResponse;
use AcquiaCloudApi\Response\PermissionsResponse;

/**
 * Class Permissions
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Permissions extends CloudApiBase
{
    /**
     * Show all available permissions.
     *
     * @return PermissionsResponse<PermissionResponse>
     */
    public function get(): PermissionsResponse
    {
        return new PermissionsResponse($this->client->request('get', '/permissions'));
    }
}
