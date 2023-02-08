<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Permissions;
use AcquiaCloudApi\Response\PermissionResponse;

class PermissionsTest extends CloudApiTestCase
{
    public function testGetAllPermissions(): void
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Permissions/getPermissions.json');
        $client = $this->getMockClient($response);

        $permissions = new Permissions($client);
        $result = $permissions->get();

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(PermissionResponse::class, $record);
        }
    }
}
