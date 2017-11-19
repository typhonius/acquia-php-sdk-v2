<?php

class TeamsTest extends CloudApiTestCase
{

    public $properties = [
        'uuid',
        'name',
        'created_at',
        'updated_at',
        'organization',
        'links'
    ];

    public function testGetTeams()
    {

        $response = $this->generateCloudApiResponse('Endpoints/getTeams.json');
        $teams = new \AcquiaCloudApi\Response\TeamsResponse($response);

        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['teams'])
        ->getMock();

        $client->expects($this->once())
        ->method('teams')
        ->will($this->returnValue($teams));

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
