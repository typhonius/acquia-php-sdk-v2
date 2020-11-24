<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Organizations;
use AcquiaCloudApi\Endpoints\Roles;

class RolesTest extends CloudApiTestCase
{
    /**
     * @var mixed[] $properties
     */
    public $properties = [
        'uuid',
        'name',
        'description',
        'last_edited',
        'permissions',
    ];

    public function testGetRole(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Roles/getRole.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $roles = new Roles($client);
        $result = $roles->get('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\RolesResponse', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\RoleResponse', $result);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testGetRoles(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Roles/getAllRoles.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $roles = new Roles($client);
        $result = $roles->getAll('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\RolesResponse', $result);
        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\RoleResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testCreateRole(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Roles/createRole.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
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
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Role created.', $result->message);
    }

    public function testDeleteRole(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Roles/deleteRole.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $role = new Roles($client);
        $result = $role->delete('r47ac10b-58cc-4372-a567-0e02b2c3d470');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Deleted role.', $result->message);
    }

    public function testUpdateRole(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Roles/updateRole.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $role = new Roles($client);
        $result = $role->update('r47ac10b-58cc-4372-a567-0e02b2c3d470', ['pull from prod']);

        $requestOptions = [
            'json' => [
                'permissions' => ['pull from prod'],
            ],
        ];
        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Updating role.', $result->message);
    }
}
