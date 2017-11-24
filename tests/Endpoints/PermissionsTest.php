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

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getPermissions.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
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
