<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Teams;
use AcquiaCloudApi\Response\ApplicationResponse;
use AcquiaCloudApi\Response\TeamResponse;

class TeamsTest extends CloudApiTestCase
{
    public function testGetTeams(): void
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Teams/getAllTeams.json');
        $client = $this->getMockClient($response);

        $team = new Teams($client);
        $result = $team->getAll();

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(TeamResponse::class, $record);
        }
    }

    public function testCreateTeamInvite(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Teams/invite.json');
        $client = $this->getMockClient($response);

        $team = new Teams($client);
        $result = $team->invite(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            'hello@example.com',
            ['access permissions', 'access servers']
        );

        $requestOptions = [
            'json' => [
                'email' => 'hello@example.com',
                'roles' => ['access permissions', 'access servers'],
            ],
        ];
        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals("Invited team member.", $result->message);
    }

    public function testCreateTeam(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Teams/createTeam.json');
        $client = $this->getMockClient($response);

        $organization = new Teams($client);
        $result = $organization->create('8ff6c046-ec64-4ce4-bea6-27845ec18600', 'Mega Team');

        $requestOptions = [
            'json' => [
                'name' => 'Mega Team',
            ],
        ];
        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals("Team created.", $result->message);
    }

    public function testRenameTeam(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Teams/rename.json');
        $client = $this->getMockClient($response);

        $team = new Teams($client);
        $result = $team->rename('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 'My Cool Application');

        $requestOptions = [
            'json' => [
                'name' => 'My Cool Application',
            ],
        ];
        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals("Team renamed.", $result->message);
    }

    public function testDeleteTeam(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Teams/deleteTeam.json');
        $client = $this->getMockClient($response);

        $team = new Teams($client);
        $result = $team->delete('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertEquals("Removed team.", $result->message);
    }

    public function testAddApplicationToTeam(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Teams/addApplication.json');
        $client = $this->getMockClient($response);

        $team = new Teams($client);
        $result = $team->addApplication(
            '8ff6c046-ec64-4ce4-bea6-27845ec18600',
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851'
        );

        $requestOptions = [
            'json' => [
                'uuid' => '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            ],
        ];
        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals('Added application to team.', $result->message);
    }

    public function testGetTeamApplications(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Teams/getApplications.json');
        $client = $this->getMockClient($response);

        $team = new Teams($client);
        $result = $team->getApplications('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(ApplicationResponse::class, $record);
        }
    }
}
