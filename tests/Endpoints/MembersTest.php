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
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getOrganizationMembers.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
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

    public function testMemberDelete()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/deleteMember.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->deleteMember('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals("Organization member removed.", $result->message);
    }
}
