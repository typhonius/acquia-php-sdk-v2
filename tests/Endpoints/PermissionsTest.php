<?php

class PermissionsTest extends CloudApiTestCase
{

    public $properties = [
    'name',
    'label',
    'description',
    'group_label',
    ];

    public function testGetAllPermissions()
    {

        $response = (array) $this->generateCloudApiResponse('Endpoints/getPermissions.json');
        $branches = new \AcquiaCloudApi\Response\PermissionsResponse($response);


        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['permissions'])
        ->getMock();
        $client->expects($this->once())
        ->method('permissions')
        ->will($this->returnValue($branches));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->permissions();

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\PermissionsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\PermissionResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }
}
