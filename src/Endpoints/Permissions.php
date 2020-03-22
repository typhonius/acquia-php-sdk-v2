<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\PermissionsResponse;

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
     * @return PermissionsResponse
     */
    public function get()
    {
        return new PermissionsResponse($this->client->request('get', '/permissions'));
    }
}
