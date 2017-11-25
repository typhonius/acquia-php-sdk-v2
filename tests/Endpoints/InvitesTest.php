<?php

class InvitesTest extends CloudApiTestCase
{

    public $properties = [
          'uuid',
          'email',
          'author',
          'applications',
          'organization',
          'roles',
          'team',
          'created_at',
          'token',
          'flags',
          'links',
    ];

    public function testGetOrganizationInvitees()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getOrganizationInvitees.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->invitees('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\InvitationsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\InvitationResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }
}
