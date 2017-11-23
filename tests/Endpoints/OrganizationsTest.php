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

        /** @var AcquiaCloudApi\CloudApi\Client $client */
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
}
