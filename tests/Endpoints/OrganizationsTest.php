<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Organizations;

class OrganizationsTest extends CloudApiTestCase
{

    public $organizationProperties = [
        'id',
        'uuid',
        'name',
        'owner',
        'subscriptions_total',
        'admins_total',
        'users_total',
        'teams_total',
        'roles_total',
        'links'
    ];

    public $invitationProperties = [
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
        'links'
    ];

    protected $applicationProperties = [
        'uuid',
        'name',
        'hosting',
        'subscription',
        'organization',
        'type',
        'flags',
        'status',
        'links'
    ];

    protected $teamProperties = [
        'uuid',
        'name',
        'created_at',
        'updated_at',
        'organization',
        'links'
    ];

    public function testGetOrganizations()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Organizations/getAllOrganizations.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $organization = new Organizations($client);
        $result = $organization->getAll();

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OrganizationsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\OrganizationResponse', $record);

            foreach ($this->organizationProperties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testCreateOrganizationAdminInvite()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Organizations/inviteAdmin.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $organization = new Organizations($client);
        $result = $organization->inviteAdmin('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 'user@example.com');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Invited organization administrator.', $result->message);
    }

    public function testGetOrganizationApplications()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Organizations/getApplications.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $organization = new Organizations($client);
        $result = $organization->getApplications('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\ApplicationsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\ApplicationResponse', $record);

            foreach ($this->applicationProperties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetOrganizationTeams()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Organizations/getTeams.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $organization = new Organizations($client);
        $result = $organization->getTeams('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\TeamsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\TeamResponse', $record);

            foreach ($this->teamProperties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetOrganizationInvitees()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Organizations/getMemberInvites.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $organization = new Organizations($client);
        $result = $organization->getMemberInvitations('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\InvitationsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\InvitationResponse', $record);

            foreach ($this->invitationProperties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testLeaveOrganization()
    {
        $response = $this->getPsr7GzipResponseForFixture('Endpoints/Organizations/leaveOrganization.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $organization = new Organizations($client);
        $result  = $organization->leaveOrganization('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Left organization.', $result->message);
    }

    public function testChangeOwner()
    {
        $response = $this->getPsr7GzipResponseForFixture('Endpoints/Organizations/changeOwner.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $organization = new Organizations($client);
        $result  = $organization->changeOwner(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            '82cff7ec-2f09-11e9-b210-d663bd873d93'
        );

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals("Changed organization owner.", $result->message);
    }
}
