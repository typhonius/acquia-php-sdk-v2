<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Organization;
use AcquiaCloudApi\Endpoints\Application;
use AcquiaCloudApi\Endpoints\Team;

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

    public function testGetOrganizations()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getOrganizations.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $organization = new Organization($client);
        $result = $organization->getOrganizations();

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
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/createOrganizationAdminInvite.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $team = new Team($client);
        $result = $team->createOrganizationAdminInvite('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 'user@example.com');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Invited organization administrator.', $result->message);
    }

    public function testGetOrganizationApplications()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getOrganizationApplications.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $organization = new Organization($client);
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
}
