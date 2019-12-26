<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Organizations;
use AcquiaCloudApi\Endpoints\Roles;

class RolesTest extends CloudApiTestCase
{

    public $properties = [
    'uuid',
    'name',
    'description',
    'last_edited',
    'permissions',
    ];

    public function testGetRole()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Roles/getRole.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $roles = new Roles($client);
        $result = $roles->get('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\RolesResponse', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\RoleResponse', $result);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testGetRoles()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Roles/getAllRoles.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $roles = new Roles($client);
        $result = $roles->getAll('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\RolesResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\RoleResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testCreateRole()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Roles/createRole.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $roles = new Roles($client);
        $result = $roles->create(
            '8ff6c046-ec64-4ce4-bea6-27845ec18600',
            'My new role',
            ['access cloud api', 'pull from prod'],
            'My new role description'
        );

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Role created.', $result->message);
    }

    public function testDeleteRole()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Roles/deleteRole.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $role = new Roles($client);
        $result = $role->delete('r47ac10b-58cc-4372-a567-0e02b2c3d470');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Deleted role.', $result->message);
    }

    public function testUpdateRole()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Roles/updateRole.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $role = new Roles($client);
        $result = $role->update('r47ac10b-58cc-4372-a567-0e02b2c3d470', ['pull from prod']);

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Updating role.', $result->message);
    }
}
