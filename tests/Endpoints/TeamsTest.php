<?php

class TeamsTest extends CloudApiTestCase
{

    protected $properties = [
        'uuid',
        'name',
        'created_at',
        'updated_at',
        'organization',
        'links'
    ];

    public function testGetTeams()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getTeams.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->teams();

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\TeamsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\TeamResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testCreateTeamInvite()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/createTeamInvite.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->createTeamInvite(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            'hello@example.com',
            ['access permissions', 'access servers']
        );

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals("Invited team member.", $result->message);
    }

    public function testCreateTeam()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/createTeam.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->createTeam('8ff6c046-ec64-4ce4-bea6-27845ec18600', 'Mega Team');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals("Team created.", $result->message);
    }

    public function testRenameTeam()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/RenameTeam.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->renameTeam('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 'My Cool Application');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals("Team renamed.", $result->message);
    }

    public function testDeleteTeam()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/DeleteTeam.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->deleteTeam('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals("Removed team.", $result->message);
    }

    public function testGetOrganizationTeams()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getOrganizationTeams.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->organizationTeams('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\TeamsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\TeamResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testAddApplicationToTeam()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/addApplicationToTeam.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->addApplicationToTeam('8ff6c046-ec64-4ce4-bea6-27845ec18600', '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Added application to team.', $result->message);
    }
}
