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

    public $inviteProperties = [
          'uuid',
          'email',
          'author',
          'applications',
          'organizations',
          'roles',
          'team',
          'created_at',
          'token',
          'flags',
          'links',
    ];

    public function testGetOrganizationMembers()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getOrganizationMembers.json');
        $client = $this->getMockClient($response);

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

    public function testGetOrganizationInvitees()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getOrganizationInvitees.json');
        $client = $this->getMockClient($response);

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->invitees('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\InvitationsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\InvitationResponse', $record);

            foreach ($this->inviteProperties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testMemberDelete()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/deleteMember.json');
        $client = $this->getMockClient($response);

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->deleteMember('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals("Organization member removed.", $result->message);
    }
}
