<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Organizations;
use AcquiaCloudApi\Response\OrganizationResponse;
use AcquiaCloudApi\Response\InvitationResponse;
use AcquiaCloudApi\Response\TeamResponse;
use AcquiaCloudApi\Response\ApplicationResponse;

class OrganizationsTest extends CloudApiTestCase
{
    public function testGetOrganizations(): void
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Organizations/getAllOrganizations.json');
        $client = $this->getMockClient($response);

        $organization = new Organizations($client);
        $result = $organization->getAll();

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(OrganizationResponse::class, $record);
        }
    }

    public function testCreateOrganizationAdminInvite(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Organizations/inviteAdmin.json');
        $client = $this->getMockClient($response);

        $organization = new Organizations($client);
        $result = $organization->inviteAdmin('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 'user@example.com');

        $requestOptions = [
            'json' => [
                'email' => 'user@example.com',
            ],
        ];
        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals('Invited organization administrator.', $result->message);
    }

    public function testGetOrganizationApplications(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Organizations/getApplications.json');
        $client = $this->getMockClient($response);

        $organization = new Organizations($client);
        $result = $organization->getApplications('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(ApplicationResponse::class, $record);
        }
    }

    public function testGetOrganizationTeams(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Organizations/getTeams.json');
        $client = $this->getMockClient($response);

        $organization = new Organizations($client);
        $result = $organization->getTeams('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(TeamResponse::class, $record);
        }
    }

    public function testGetOrganizationInvitees(): void
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Organizations/getMemberInvites.json');
        $client = $this->getMockClient($response);

        $organization = new Organizations($client);
        $result = $organization->getMemberInvitations('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(InvitationResponse::class, $record);
        }
    }

    public function testLeaveOrganization(): void
    {
        $response = $this->getPsr7GzipResponseForFixture('Endpoints/Organizations/leaveOrganization.json');
        $client = $this->getMockClient($response);

        $organization = new Organizations($client);
        $result  = $organization->leaveOrganization('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertEquals('Left organization.', $result->message);
    }

    public function testChangeOwner(): void
    {
        $response = $this->getPsr7GzipResponseForFixture('Endpoints/Organizations/changeOwner.json');
        $client = $this->getMockClient($response);

        $organization = new Organizations($client);
        $result  = $organization->changeOwner(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            '82cff7ec-2f09-11e9-b210-d663bd873d93'
        );

        $requestOptions = [
            'json' => [
                'user_uuid' => '82cff7ec-2f09-11e9-b210-d663bd873d93',
            ],
        ];
        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals("Changed organization owner.", $result->message);
    }
}
