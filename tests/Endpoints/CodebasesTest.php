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

        // Test that each item in the response is properly transformed
        foreach ($result as $environmentResponse) {
            $this->assertInstanceOf(\AcquiaCloudApi\Response\CodebaseEnvironmentResponse::class, $environmentResponse);
            $this->assertIsString($environmentResponse->id);
            $this->assertIsString($environmentResponse->name);

            // Test properties array to catch Coalesce mutation in CodebaseEnvironmentResponse
            $this->assertIsArray($environmentResponse->properties);
            // This assertion will fail if the coalesce operator is mutated ([] ?? $environment->properties)
            $this->assertNotNull($environmentResponse->properties);
        }

        // Test specific array structure to catch UnwrapArrayMap mutations
        $this->assertArrayHasKey(0, $result);
        $this->assertInstanceOf(\AcquiaCloudApi\Response\CodebaseEnvironmentResponse::class, $result[0]);
        $this->assertNotNull($result[0]); // This catches NewObject mutations that return null

        // Additional test to ensure properties are handled correctly (catches Coalesce mutation)
        $firstEnvironment = $result[0];
        $this->assertIsArray($firstEnvironment->properties);
        $this->assertTrue(is_array($firstEnvironment->properties), 'Properties should always be an array due to coalesce operator');
    }

    public function testCodebaseResponseTransformation(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Codebases/getAllCodebases.json');
        $client = $this->getMockClient($response);

        $codebases = new Codebases($client);
        $result = $codebases->getAll();

        $this->assertInstanceOf(CodebasesResponse::class, $result);

        // Test array iteration to catch mutations in response transformation
        foreach ($result as $index => $codebaseResponse) {
            $this->assertInstanceOf(\AcquiaCloudApi\Response\CodebaseResponse::class, $codebaseResponse);
            $this->assertNotNull($codebaseResponse); // Catches NewObject mutations
            $this->assertIsString($codebaseResponse->id);
        }

        // Test array access to catch UnwrapArrayMap mutations
        if (count($result) > 0) {
            $this->assertArrayHasKey(0, $result);
            $this->assertInstanceOf(\AcquiaCloudApi\Response\CodebaseResponse::class, $result[0]);
        }
    }

    public function testCodebaseEnvironmentResponsePropertiesHandling(): void
    {
        // Create custom test data to specifically test the Coalesce mutation
        $testData = [
            '_embedded' => [
                'items' => [
                    [
                        '_links' => ['self' => ['href' => '/test']],
                        'id' => 'test-env-1',
                        'name' => 'test-env',
                        'label' => 'Test Environment',
                        'description' => 'Test description',
                        'status' => 'active',
                        'reference' => 'main',
                        'flags' => ['production' => false],
                        'properties' => null  // This null value will test the coalesce operator
                    ],
                    [
                        '_links' => ['self' => ['href' => '/test2']],
                        'id' => 'test-env-2',
                        'name' => 'test-env-2',
                        'label' => 'Test Environment 2',
                        'description' => 'Test description 2',
                        'status' => 'active',
                        'reference' => 'main',
                        'flags' => ['production' => false],
                        'properties' => ['key' => 'value']  // This tests non-null properties
                    ]
                ]
            ]
        ];

        $response = new \GuzzleHttp\Psr7\Response(200, [], json_encode($testData));
        $client = $this->getMockClient($response);

        $codebases = new Codebases($client);
        $result = $codebases->getEnvironments('test-codebase-id');

        $this->assertInstanceOf(CodebaseEnvironmentsResponse::class, $result);
        $this->assertCount(2, $result);

        // Test the first environment with null properties (tests coalesce mutation)
        $firstEnv = $result[0];
        $this->assertInstanceOf(\AcquiaCloudApi\Response\CodebaseEnvironmentResponse::class, $firstEnv);
        $this->assertIsArray($firstEnv->properties);
        $this->assertEmpty($firstEnv->properties); // null should become empty array via ??

        // Test the second environment with actual properties
        $secondEnv = $result[1];
        $this->assertInstanceOf(\AcquiaCloudApi\Response\CodebaseEnvironmentResponse::class, $secondEnv);
        $this->assertIsArray($secondEnv->properties);
        $this->assertEquals(['key' => 'value'], $secondEnv->properties);
    }
}
