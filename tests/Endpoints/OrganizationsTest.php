<?php

class OrganizationsTest extends CloudApiTestCase
{

    public $properties = [
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

    public function testGetOrganizations()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getOrganizations.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->organizations();

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OrganizationsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\OrganizationResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testCreateOrganizationAdminInvite()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/createOrganizationAdminInvite.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->createOrganizationAdminInvite('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 'user@example.com');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Invited organization administrator.', $result->message);
    }
}
