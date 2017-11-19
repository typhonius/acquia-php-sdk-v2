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

        $response = $this->generateCloudApiResponse('Endpoints/getOrganizationRoles.json');
        $roles = new \AcquiaCloudApi\Response\RolesResponse($response);

        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['organizationRoles'])
        ->getMock();

        $client->expects($this->once())
        ->method('organizationRoles')
        ->with('8ff6c046-ec64-4ce4-bea6-27845ec18600')
        ->will($this->returnValue($roles));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
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

        $response = $this->generateCloudApiResponse('Endpoints/addRole.json');
        $task = new \AcquiaCloudApi\Response\OperationResponse($response);

        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['organizationRoleCreate'])
        ->getMock();

        $client->expects($this->once())
        ->method('organizationRoleCreate')
        ->with('8ff6c046-ec64-4ce4-bea6-27845ec18600')
        ->will($this->returnValue($task));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->organizationRoleCreate(
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

        $response = $this->generateCloudApiResponse('Endpoints/deleteRole.json');
        $task = new \AcquiaCloudApi\Response\OperationResponse($response);

        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['roleRemove'])
        ->getMock();

        $client->expects($this->once())
        ->method('roleRemove')
        ->with('r47ac10b-58cc-4372-a567-0e02b2c3d470')
        ->will($this->returnValue($task));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->roleRemove('r47ac10b-58cc-4372-a567-0e02b2c3d470');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Deleted role.', $result->message);
    }

    public function testUpdateRole()
    {

        $response = $this->generateCloudApiResponse('Endpoints/updateRole.json');
        $task = new \AcquiaCloudApi\Response\OperationResponse($response);

        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['roleUpdatePermissions'])
        ->getMock();

        $client->expects($this->once())
        ->method('roleUpdatePermissions')
        ->with('r47ac10b-58cc-4372-a567-0e02b2c3d470', ['pull from prod'])
        ->will($this->returnValue($task));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->roleUpdatePermissions('r47ac10b-58cc-4372-a567-0e02b2c3d470', ['pull from prod']);

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Updating role.', $result->message);
    }
}
