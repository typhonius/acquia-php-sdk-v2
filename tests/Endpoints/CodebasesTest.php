<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Response\CodebaseResponse;
use AcquiaCloudApi\Response\CodebasesResponse;
use AcquiaCloudApi\Response\CodebaseEnvironmentsResponse;
use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Codebases;

class CodebasesTest extends CloudApiTestCase
{
    public function testGetAll(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Codebases/getAllCodebases.json');
        $client = $this->getMockClient($response);

        $codebases = new Codebases($client);
        $result = $codebases->getAll();

        $this->assertEquals($response->getStatusCode(), 200);

        $this->assertInstanceOf(CodebasesResponse::class, $result);
        $this->assertNotEmpty($result);
    }

    public function testGetCodebase(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Codebases/getCodebase.json');
        $client = $this->getMockClient($response);

        $codebases = new Codebases($client);
        $result = $codebases->get('11111111-041c-44c7-a486-7972ed2cafc8');

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertNotEmpty($result);
        $this->assertInstanceOf(CodebaseResponse::class, $result);
    }

    public function testGetCodebaseEnvironments(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Codebases/getCodebaseEnvironments.json');
        $client = $this->getMockClient($response);

        $codebases = new Codebases($client);
        $result = $codebases->getEnvironments('11111111-041c-44c7-a486-7972ed2cafc8');

        $this->assertInstanceOf(CodebaseEnvironmentsResponse::class, $result);
        $this->assertNotEmpty($result);
    }
}
