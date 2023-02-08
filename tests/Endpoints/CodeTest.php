<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Code;
use AcquiaCloudApi\Response\BranchResponse;

class CodeTest extends CloudApiTestCase
{
    public function testGetBranches(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Code/getAllCode.json');
        $client = $this->getMockClient($response);

        $code = new Code($client);
        $result = $code->getAll('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(BranchResponse::class, $record);
        }
    }

    public function testCodeSwitch(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Code/switchCode.json');
        $client = $this->getMockClient($response);

        $code = new Code($client);
        $result = $code->switch('8ff6c046-ec64-4ce4-bea6-27845ec18600', 'my-feature-branch');

        $requestOptions = [
            'json' => [
                'branch' => 'my-feature-branch',
            ],
        ];

        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals('Switching code.', $result->message);
    }

    public function testCodeDeploy(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Code/deployCode.json');
        $client = $this->getMockClient($response);

        $code = new Code($client);
        $result = $code->deploy(
            '8ff6c046-ec64-4ce4-bea6-27845ec18600',
            'f9ef59eb-13ee-4050-8120-5524d8ce9821',
            'Commit message'
        );

        $requestOptions = [
            'json' => [
                'source' => '8ff6c046-ec64-4ce4-bea6-27845ec18600',
                'message' => 'Commit message',
            ],
        ];

        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals('Deploying code.', $result->message);
    }
}
