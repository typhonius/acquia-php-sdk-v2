<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Roles;
use AcquiaCloudApi\Response\RolesResponse;
use AcquiaCloudApi\Response\RoleResponse;

class RolesTest extends CloudApiTestCase
{
    public function testGetRole(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Roles/getRole.json');
        $client = $this->getMockClient($response);

        $roles = new Roles($client);
        $result = $roles->get('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertNotInstanceOf(RolesResponse::class, $result);
    }

    public function testGetRoles(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Roles/getAllRoles.json');
        $client = $this->getMockClient($response);

        $roles = new Roles($client);
        $result = $roles->getAll('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(RoleResponse::class, $record);
        }
    }

    public function testCreateRole(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Roles/createRole.json');
        $client = $this->getMockClient($response);

        $roles = new Roles($client);
        $result = $roles->create(
            '8ff6c046-ec64-4ce4-bea6-27845ec18600',
            'My new role',
            ['access cloud api', 'pull from prod'],
            'My new role description'
        );

        $requestOptions = [
            'json' => [
                'name' => 'My new role',
                'permissions' => ['access cloud api', 'pull from prod'],
                'description' => 'My new role description',
            ],
        ];
        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals('Role created.', $result->message);
    }

    public function testDeleteRole(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Roles/deleteRole.json');
        $client = $this->getMockClient($response);

        $role = new Roles($client);
        $result = $role->delete('r47ac10b-58cc-4372-a567-0e02b2c3d470');

        $this->assertEquals('Deleted role.', $result->message);
    }

    public function testUpdateRole(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Roles/updateRole.json');
        $client = $this->getMockClient($response);

        $role = new Roles($client);
        $result = $role->update('r47ac10b-58cc-4372-a567-0e02b2c3d470', ['pull from prod']);

        $requestOptions = [
            'json' => [
                'permissions' => ['pull from prod'],
            ],
        ];
        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals('Updating role.', $result->message);
    }
}
