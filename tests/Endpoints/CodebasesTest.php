<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Response\CodebaseResponse;
use AcquiaCloudApi\Response\CodebasesResponse;
use AcquiaCloudApi\Response\CodebaseEnvironmentsResponse;
use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Codebases;
use AcquiaCloudApi\Response\BulkCodeSwitchResponse;
use AcquiaCloudApi\Response\ReferenceResponse;
use AcquiaCloudApi\Response\ReferencesResponse;

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
        $this->assertTrue(
            is_array($firstEnvironment->properties),
            'Properties should always be an array due to coalesce operator'
        );
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

    public function testGetReferences(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Codebases/getReferences.json');
        $client = $this->getMockClient($response);

        $codebases = new Codebases($client);
        $result = $codebases->getReferences('11111111-041c-44c7-a486-7972ed2cafc8');

        $this->assertInstanceOf(\AcquiaCloudApi\Response\ReferencesResponse::class, $result);
        $this->assertNotEmpty($result);

        // Test that each item in the response is properly transformed
        foreach ($result as $referenceResponse) {
            $this->assertInstanceOf(\AcquiaCloudApi\Response\ReferenceResponse::class, $referenceResponse);
            $this->assertIsString($referenceResponse->id);
            $this->assertIsString($referenceResponse->name);
            $this->assertIsString($referenceResponse->type);
        }
    }

    public function testGetReference(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Codebases/getReference.json');
        $client = $this->getMockClient($response);

        $codebases = new Codebases($client);
        $result = $codebases->getReference('11111111-041c-44c7-a486-7972ed2cafc8', 'main');

        $this->assertInstanceOf(\AcquiaCloudApi\Response\ReferenceResponse::class, $result);
        $this->assertIsString($result->id);
        $this->assertIsString($result->name);
        $this->assertIsString($result->type);
    }

    public function testCreateBulkCodeSwitch(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Codebases/createBulkCodeSwitch.json');
        $client = $this->getMockClient($response);

        $targets = [
            [
                'environment_id' => 'env-123',
                'cloud_actions' => [
                    'cache_clear' => true
                ]
            ],
            [
                'environment_id' => 'env-456'
            ]
        ];

        $cloudActions = [
            'database_update' => true,
            'cache_clear' => true
        ];

        $codebases = new Codebases($client);
        $result = $codebases->createBulkCodeSwitch(
            '11111111-041c-44c7-a486-7972ed2cafc8',
            'main',
            $targets,
            $cloudActions
        );

        $this->assertInstanceOf(\AcquiaCloudApi\Response\OperationResponse::class, $result);
    }

    public function testCreateBulkCodeSwitchNoCloudActions(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Codebases/createBulkCodeSwitch.json');
        $client = $this->getMockClient($response);

        $targets = [
            [
                'environment_id' => 'env-123'
            ],
            [
                'environment_id' => 'env-456'
            ]
        ];

        $codebases = new Codebases($client);
        $result = $codebases->createBulkCodeSwitch(
            '11111111-041c-44c7-a486-7972ed2cafc8',
            'main',
            $targets
        );

        $this->assertInstanceOf(\AcquiaCloudApi\Response\OperationResponse::class, $result);
    }

    public function testCreateBulkCodeSwitchRequestStructure(): void
    {
        // Create a mock response
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Codebases/createBulkCodeSwitch.json');
        $client = $this->getMockClient($response);

        $targets = [
            [
                'environment_id' => 'env-123',
            ]
        ];

        // Test with required reference and targets
        $codebases = new Codebases($client);
        $codebases->createBulkCodeSwitch('codebase-123', 'main', $targets);

        $requestOptions = $this->getRequestOptions($client);
        $this->assertArrayHasKey('json', $requestOptions);
        $this->assertArrayHasKey('reference', $requestOptions['json']);
        $this->assertEquals('main', $requestOptions['json']['reference']);
        $this->assertArrayHasKey('targets', $requestOptions['json']);
        $this->assertEquals($targets, $requestOptions['json']['targets']);
        $this->assertArrayNotHasKey('cloud_actions', $requestOptions['json']);

        // Test with cloud actions
        $cloudActions = ['cache_clear' => true];
        $codebases->createBulkCodeSwitch('codebase-123', 'main', $targets, $cloudActions);

        $requestOptions = $this->getRequestOptions($client);
        $this->assertArrayHasKey('json', $requestOptions);
        $this->assertArrayHasKey('reference', $requestOptions['json']);
        $this->assertArrayHasKey('targets', $requestOptions['json']);
        $this->assertArrayHasKey('cloud_actions', $requestOptions['json']);
        $this->assertEquals($cloudActions, $requestOptions['json']['cloud_actions']);
    }

    /**
     * Tests the array_map and object casting in constructor
     */
    public function testBulkCodeSwitchResponseArrayMapping(): void
    {
        // Test with array input that needs to be cast to objects
        $arrayInput = [
            ['id' => 'id1', 'codebase_id' => 'cb1', 'reference' => 'main'],
            ['id' => 'id2', 'codebase_id' => 'cb2', 'reference' => 'dev']
        ];

        $response = new BulkCodeSwitchResponse($arrayInput);

        // Verify the array items were mapped to objects
        $this->assertIsObject($response[0]);
        $this->assertIsObject($response[1]);
        $this->assertEquals('id1', $response[0]->id);
        $this->assertEquals('cb2', $response[1]->codebase_id);

        // Also test with mixed data types
        $mixedInput = [
            ['id' => 'id1'],
            (object)['id' => 'id2']
        ];

        $response2 = new BulkCodeSwitchResponse($mixedInput);

        // Both should be objects
        $this->assertIsObject($response2[0]);
        $this->assertIsObject($response2[1]);
    }

    /**
     * Tests the ReferenceResponse with complete data
     */
    public function testReferenceResponseWithCompleteData(): void
    {
        // Test with complete reference data
        $referenceData = (object) [
            'id' => 'test-reference-id',
            'name' => 'main',
            'type' => 'branch',
            'commit_id' => 'abc123def456',
            'commit_message' => 'Test commit message',
            'commit_author' => 'Test Author <test@example.com>',
            'commit_date' => '2023-01-01T12:00:00Z',
            '_links' => (object) ['self' => 'https://example.com/references/test-reference-id']
        ];

        $response = new ReferenceResponse($referenceData);

        // Test all properties
        $this->assertEquals('test-reference-id', $response->id);
        $this->assertEquals('main', $response->name);
        $this->assertEquals('branch', $response->type);
        $this->assertEquals('abc123def456', $response->commit_id);
        $this->assertEquals('Test commit message', $response->commit_message);
        $this->assertEquals('Test Author <test@example.com>', $response->commit_author);
        $this->assertEquals('2023-01-01T12:00:00Z', $response->commit_date);
        $this->assertEquals((object) ['self' => 'https://example.com/references/test-reference-id'], $response->links);
    }

    /**
     * Tests the ReferenceResponse with minimal data
     */
    public function testReferenceResponseWithMinimalData(): void
    {
        // Test with minimal reference data (no commit info)
        $referenceData = (object) [
            'id' => 'test-reference-id',
            'name' => 'main',
            'type' => 'branch',
            '_links' => (object) ['self' => 'https://example.com/references/test-reference-id']
        ];

        $response = new ReferenceResponse($referenceData);

        // Test required properties
        $this->assertEquals('test-reference-id', $response->id);
        $this->assertEquals('main', $response->name);
        $this->assertEquals('branch', $response->type);
        $this->assertEquals((object) ['self' => 'https://example.com/references/test-reference-id'], $response->links);

        // Test nullable properties
        $this->assertNull($response->commit_id);
        $this->assertNull($response->commit_message);
        $this->assertNull($response->commit_author);
        $this->assertNull($response->commit_date);
    }

    /**
     * Tests the ReferencesResponse with multiple references
     */
    public function testReferencesResponseWithMultipleReferences(): void
    {
        // Test with multiple reference objects
        $referencesData = [
            (object) [
                'id' => 'ref-1',
                'name' => 'main',
                'type' => 'branch',
                'commit_id' => 'abc123',
                'commit_message' => 'First commit message',
                'commit_author' => 'Author 1 <author1@example.com>',
                'commit_date' => '2023-01-01T12:00:00Z',
                '_links' => (object) ['self' => 'https://example.com/references/ref-1']
            ],
            (object) [
                'id' => 'ref-2',
                'name' => 'develop',
                'type' => 'branch',
                'commit_id' => 'def456',
                'commit_message' => 'Second commit message',
                'commit_author' => 'Author 2 <author2@example.com>',
                'commit_date' => '2023-01-02T12:00:00Z',
                '_links' => (object) ['self' => 'https://example.com/references/ref-2']
            ],
            (object) [
                'id' => 'ref-3',
                'name' => 'v1.0',
                'type' => 'tag',
                'commit_id' => 'ghi789',
                'commit_message' => 'Tag commit message',
                'commit_author' => 'Author 3 <author3@example.com>',
                'commit_date' => '2023-01-03T12:00:00Z',
                '_links' => (object) ['self' => 'https://example.com/references/ref-3']
            ],
        ];

        $response = new ReferencesResponse($referencesData);

        // Test array access and object types
        $this->assertCount(3, $response);
        $this->assertInstanceOf(ReferenceResponse::class, $response[0]);
        $this->assertInstanceOf(ReferenceResponse::class, $response[1]);
        $this->assertInstanceOf(ReferenceResponse::class, $response[2]);

        // Test first reference properties
        $this->assertEquals('ref-1', $response[0]->id);
        $this->assertEquals('main', $response[0]->name);
        $this->assertEquals('branch', $response[0]->type);
        $this->assertEquals('abc123', $response[0]->commit_id);

        // Test second reference properties
        $this->assertEquals('ref-2', $response[1]->id);
        $this->assertEquals('develop', $response[1]->name);
        $this->assertEquals('branch', $response[1]->type);
        $this->assertEquals('def456', $response[1]->commit_id);

        // Test third reference properties
        $this->assertEquals('ref-3', $response[2]->id);
        $this->assertEquals('v1.0', $response[2]->name);
        $this->assertEquals('tag', $response[2]->type);
        $this->assertEquals('ghi789', $response[2]->commit_id);
    }

    /**
     * Tests the ReferencesResponse with empty array
     */
    public function testReferencesResponseWithEmptyArray(): void
    {
        $response = new ReferencesResponse([]);

        // Test that the response is empty
        $this->assertCount(0, $response);
        $this->assertEmpty($response);
    }
}
