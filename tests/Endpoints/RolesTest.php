<?php

class RolesTest extends CloudApiTestCase
{

    public $properties = [
    'uuid',
    'name',
    'description',
    'last_edited',
    'permissions',
    ];

    public function testGetRoles()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getOrganizationRoles.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->organizationRoles('8ff6c046-ec64-4ce4-bea6-27845ec18600');

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

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/addRole.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->createRole(
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

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/deleteRole.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->deleteRole('r47ac10b-58cc-4372-a567-0e02b2c3d470');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Deleted role.', $result->message);
    }

    public function testUpdateRole()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateRole.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->updateRole('r47ac10b-58cc-4372-a567-0e02b2c3d470', ['pull from prod']);

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Updating role.', $result->message);
    }
}
