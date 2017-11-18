<?php

class MembersTest extends CloudApiTestCase
{

    public $properties = [
    'uuid',
    'teams',
    'first_name',
    'last_name',
    'mail',
    'picture_url',
    'username',
    'links'
    ];

    public function testGetOrganizationMembers()
    {

        $response = $this->generateCloudApiResponse('Endpoints/getOrganizationMembers.json');
        $organizations = new \AcquiaCloudApi\Response\MembersResponse($response);


        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['members'])
        ->getMock();

        $client->expects($this->once())
        ->method('members')
        ->with('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851')
        ->will($this->returnValue($organizations));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->members('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\MembersResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\MemberResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }
}
