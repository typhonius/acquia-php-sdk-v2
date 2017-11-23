<?php

class CodeTest extends CloudApiTestCase
{

    public $properties = [
    'name',
    'flags',
    ];

    public function testGetBranches()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getCode.json');
        $client = $this->getMockClient($response);

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->code('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\BranchesResponse', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\BranchResponse', $result);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testCodeSwitch()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/switchCode.json');
        $client = $this->getMockClient($response);

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->switchCode('8ff6c046-ec64-4ce4-bea6-27845ec18600', 'my-feature-branch');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('The code is being switched.', $result->message);
    }
}
