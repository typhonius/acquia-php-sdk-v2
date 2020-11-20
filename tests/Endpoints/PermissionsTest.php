<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Permissions;

class PermissionsTest extends CloudApiTestCase
{
    /**
     * @var mixed[] $properties
     */
    public $properties = [
        'name',
        'label',
        'description',
        'group_label',
    ];

    public function testGetAllPermissions(): void
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Permissions/getPermissions.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $permissions = new Permissions($client);
        $result = $permissions->get();

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\PermissionsResponse', $result);
        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\PermissionResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }
}
