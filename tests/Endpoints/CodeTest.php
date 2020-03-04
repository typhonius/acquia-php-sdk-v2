<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Code;

class CodeTest extends CloudApiTestCase
{

    public $properties = [
        'name',
        'flags',
    ];

    public function testGetBranches()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Code/getAllCode.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $code = new Code($client);
        $result = $code->getAll('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\BranchesResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\BranchResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testCodeSwitch()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Code/switchCode.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $code = new Code($client);
        $result = $code->switch('8ff6c046-ec64-4ce4-bea6-27845ec18600', 'my-feature-branch');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Switching code.', $result->message);
    }

    public function testCodeDeploy()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Code/deployCode.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $code = new Code($client);
        $result = $code->deploy(
            '8ff6c046-ec64-4ce4-bea6-27845ec18600',
            'f9ef59eb-13ee-4050-8120-5524d8ce9821',
            'Commit message'
        );

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Deploying code.', $result->message);
    }
}
