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

        /** @var AcquiaCloudApi\CloudApi\Client $client */
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
}
