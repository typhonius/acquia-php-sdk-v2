<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\PermissionsResponse;
use AcquiaCloudApi\Response\PermissionResponse;

/**
 * Class Permissions
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Permissions extends CloudApiBase implements CloudApiInterface
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
