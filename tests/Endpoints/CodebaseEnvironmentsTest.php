<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\CodebaseEnvironments;
use AcquiaCloudApi\Response\CodebaseEnvironmentResponse;
use AcquiaCloudApi\Response\CodebaseEnvironmentsResponse;
use AcquiaCloudApi\Response\OperationResponse;

class CodebaseEnvironmentsTest extends CloudApiTestCase
{
    public function testGetAll(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/CodebaseEnvironments/getAll.json');
        $client = $this->getMockClient($response);

        /** @var CodebaseEnvironments $environments */
        $environments = new CodebaseEnvironments($client);
        $result = $environments->getAll('9f4bc29c-c764-4920-9e6c-554f41e4774c');

        $this->assertInstanceOf(CodebaseEnvironmentsResponse::class, $result);

        // For the current implementation with ArrayObject
        // We should test accordingly based on how the class is implemented
        $this->assertCount(3, $result);
        foreach ($result as $environment) {
            $this->assertInstanceOf(CodebaseEnvironmentResponse::class, $environment);
        }
    }

    public function testGet(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/CodebaseEnvironments/getEnvironment.json');
        $client = $this->getMockClient($response);

        /** @var CodebaseEnvironments $environments */
        $environments = new CodebaseEnvironments($client);
        $result = $environments->get('9f4bc29c-c764-4920-9e6c-554f41e4774c', '24-a47ac10b-58cc-4372-a567-0e02b2c3d470');

        $this->assertInstanceOf(CodebaseEnvironmentResponse::class, $result);
        $this->assertEquals('24-a47ac10b-58cc-4372-a567-0e02b2c3d470', $result->id);
        $this->assertEquals('dev', $result->name);
        $this->assertEquals('Development', $result->label);
        $this->assertEquals('Development Environment', $result->description);
        $this->assertEquals('normal', $result->status);
        $this->assertEquals('master', $result->reference);
        $this->assertObjectHasProperty('production', $result->flags);
        $this->assertFalse($result->flags->production);
        $this->assertIsArray($result->properties);
        $this->assertArrayHasKey('drush_aliases', $result->properties);
    }

    public function testGetById(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/CodebaseEnvironments/getEnvironment.json');
        $client = $this->getMockClient($response);

        /** @var CodebaseEnvironments $environments */
        $environments = new CodebaseEnvironments($client);
        $result = $environments->getById('24-a47ac10b-58cc-4372-a567-0e02b2c3d470');

        $this->assertInstanceOf(CodebaseEnvironmentResponse::class, $result);
        $this->assertEquals('24-a47ac10b-58cc-4372-a567-0e02b2c3d470', $result->id);
        $this->assertEquals('dev', $result->name);
    }

    public function testUpdate(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/CodebaseEnvironments/update.json');
        $client = $this->getMockClient($response);

        /** @var CodebaseEnvironments $environments */
        $environments = new CodebaseEnvironments($client);
        $properties = [
            'drush_aliases' => ['new-alias'],
            'new_property' => 'new_value'
        ];
        $result = $environments->update('24-a47ac10b-58cc-4372-a567-0e02b2c3d470', $properties);

        $this->assertInstanceOf(OperationResponse::class, $result);
        $this->assertEquals('Environment properties updated.', $result->message);
    }

    public function testUpdateOptionsStructure(): void
    {
        // Create a mock response
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/CodebaseEnvironments/update.json');
        $client = $this->getMockClient($response);

        /** @var CodebaseEnvironments $environments */
        $environments = new CodebaseEnvironments($client);
        $properties = [
            'drush_aliases' => ['new-alias'],
            'new_property' => 'new_value'
        ];

        // Invoke the update method with our properties
        $environments->update('test-env', $properties);

        // Get the request options and verify they match the expected structure
        $requestOptions = $this->getRequestOptions($client);
        $this->assertArrayHasKey('json', $requestOptions);
        $this->assertArrayHasKey('properties', $requestOptions['json']);
        $this->assertEquals($properties, $requestOptions['json']['properties']);
    }

    public function testAssociatePrivateNetwork(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/CodebaseEnvironments/associatePrivateNetwork.json');
        $client = $this->getMockClient($response);

        /** @var CodebaseEnvironments $environments */
        $environments = new CodebaseEnvironments($client);
        $result = $environments->associatePrivateNetwork('24-a47ac10b-58cc-4372-a567-0e02b2c3d470', 'pn-123456');

        $this->assertInstanceOf(OperationResponse::class, $result);
        $this->assertEquals('Environment associated with private network.', $result->message);
    }

    public function testAssociatePrivateNetworkOptionsStructure(): void
    {
        // Create a mock response
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/CodebaseEnvironments/associatePrivateNetwork.json');
        $client = $this->getMockClient($response);

        /** @var CodebaseEnvironments $environments */
        $environments = new CodebaseEnvironments($client);
        $privateNetworkId = 'pn-123456';

        // Invoke the method with our private network ID
        $environments->associatePrivateNetwork('test-env', $privateNetworkId);

        // Get the request options and verify they match the expected structure
        $requestOptions = $this->getRequestOptions($client);
        $this->assertArrayHasKey('json', $requestOptions);
        $this->assertArrayHasKey('private_network_id', $requestOptions['json']);
        $this->assertEquals($privateNetworkId, $requestOptions['json']['private_network_id']);
    }

    public function testDisassociatePrivateNetwork(): void
    {
        $response = $this->getPsr7JsonResponseForFixture(
            'Endpoints/CodebaseEnvironments/disassociatePrivateNetwork.json'
        );
        $client = $this->getMockClient($response);

        /** @var CodebaseEnvironments $environments */
        $environments = new CodebaseEnvironments($client);
        $result = $environments->disassociatePrivateNetwork('24-a47ac10b-58cc-4372-a567-0e02b2c3d470');

        $this->assertInstanceOf(OperationResponse::class, $result);
        $this->assertEquals('Environment disassociated from private network.', $result->message);
    }

    public function testGetByPrivateNetwork(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/CodebaseEnvironments/getAll.json');
        $client = $this->getMockClient($response);

        /** @var CodebaseEnvironments $environments */
        $environments = new CodebaseEnvironments($client);
        $result = $environments->getByPrivateNetwork('pn-123456');

        $this->assertInstanceOf(CodebaseEnvironmentsResponse::class, $result);

        // For the current implementation with ArrayObject
        $this->assertCount(3, $result);
        foreach ($result as $environment) {
            $this->assertInstanceOf(CodebaseEnvironmentResponse::class, $environment);
        }
    }

    public function testGetBySite(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/CodebaseEnvironments/getAll.json');
        $client = $this->getMockClient($response);

        /** @var CodebaseEnvironments $environments */
        $environments = new CodebaseEnvironments($client);
        $result = $environments->getBySite('site-123456');

        $this->assertInstanceOf(CodebaseEnvironmentsResponse::class, $result);

        // For the current implementation with ArrayObject
        $this->assertCount(3, $result);
        foreach ($result as $environment) {
            $this->assertInstanceOf(CodebaseEnvironmentResponse::class, $environment);
        }
    }

    public function testCodebaseEnvironmentResponseEdgeCases(): void
    {
        // Test with codebase in _embedded property
        $environmentWithEmbeddedCodebase = (object) [
            '_links' => (object) ['self' => (object) ['href' => 'https://example.com']],
            'id' => 'env-1',
            'name' => 'dev',
            'label' => 'Dev',
            'description' => 'Development Environment',
            'status' => 'normal',
            'reference' => 'develop',
            'flags' => (object) ['production' => false],
            'properties' => ['key' => 'value'],
            '_embedded' => (object) ['codebase' => (object) ['id' => 'codebase-uuid-1']]
        ];

        $response1 = new CodebaseEnvironmentResponse($environmentWithEmbeddedCodebase);
        $this->assertEquals('codebase-uuid-1', $response1->codebase_uuid);

        // Test with codebase as direct property
        $environmentWithCodebaseProperty = (object) [
            '_links' => (object) ['self' => (object) ['href' => 'https://example.com']],
            'id' => 'env-2',
            'name' => 'stage',
            'label' => 'Stage',
            'description' => 'Staging Environment',
            'status' => 'normal',
            'reference' => 'master',
            'flags' => (object) ['production' => false],
            'properties' => ['key' => 'value'],
            'codebase' => (object) ['id' => 'codebase-uuid-2']
        ];

        $response2 = new CodebaseEnvironmentResponse($environmentWithCodebaseProperty);
        $this->assertEquals('codebase-uuid-2', $response2->codebase_uuid);

        // Test with no codebase property
        $environmentWithoutCodebase = (object) [
            '_links' => (object) ['self' => (object) ['href' => 'https://example.com']],
            'id' => 'env-3',
            'name' => 'prod',
            'label' => 'Prod',
            'description' => 'Production Environment',
            'status' => 'normal',
            'reference' => 'master',
            'flags' => (object) ['production' => true],
            'properties' => ['key' => 'value']
        ];

        $response3 = new CodebaseEnvironmentResponse($environmentWithoutCodebase);
        $this->assertIsObject($response3->codebase);
        $this->assertEquals(new \stdClass(), $response3->codebase);

        // Test with properties as null
        $environmentWithNullProperties = (object) [
            '_links' => (object) ['self' => (object) ['href' => 'https://example.com']],
            'id' => 'env-4',
            'name' => 'test',
            'label' => 'Test',
            'description' => 'Test Environment',
            'status' => 'normal',
            'reference' => 'master',
            'flags' => (object) ['production' => false],
            'properties' => null
        ];

        $response4 = new CodebaseEnvironmentResponse($environmentWithNullProperties);
        $this->assertIsArray($response4->properties);
        $this->assertEmpty($response4->properties);

        // Test with missing properties
        $environmentWithoutProperties = (object) [
            '_links' => (object) ['self' => (object) ['href' => 'https://example.com']],
            'id' => 'env-5',
            'name' => 'dev2',
            'label' => 'Dev2',
            'description' => 'Development Environment 2',
            'status' => 'normal',
            'reference' => 'develop',
            'flags' => (object) ['production' => false]
        ];

        $response5 = new CodebaseEnvironmentResponse($environmentWithoutProperties);
        $this->assertIsArray($response5->properties);
        $this->assertEmpty($response5->properties);

        // Test code_switch_status with default value
        $environmentWithoutCodeSwitchStatus = (object) [
            '_links' => (object) ['self' => (object) ['href' => 'https://example.com']],
            'id' => 'env-6',
            'name' => 'dev3',
            'label' => 'Dev3',
            'description' => 'Development Environment 3',
            'status' => 'normal',
            'reference' => 'develop',
            'flags' => (object) ['production' => false]
        ];

        $response6 = new CodebaseEnvironmentResponse($environmentWithoutCodeSwitchStatus);
        $this->assertEquals('IDLE', $response6->code_switch_status);

        // Test code_switch_status with explicit value
        $environmentWithCodeSwitchStatus = (object) [
            '_links' => (object) ['self' => (object) ['href' => 'https://example.com']],
            'id' => 'env-7',
            'name' => 'dev4',
            'label' => 'Dev4',
            'description' => 'Development Environment 4',
            'status' => 'normal',
            'reference' => 'develop',
            'flags' => (object) ['production' => false],
            'code_switch_status' => 'RUNNING'
        ];

        $response7 = new CodebaseEnvironmentResponse($environmentWithCodeSwitchStatus);
        $this->assertEquals('RUNNING', $response7->code_switch_status);
        // Test code_switch_status with explicit value
        $environmentWithSshUrl = (object) [
            '_links' => (object) ['self' => (object) ['href' => 'https://example.com']],
            'id' => 'env-7',
            'name' => 'dev4',
            'label' => 'Dev4',
            'description' => 'Development Environment 4',
            'status' => 'normal',
            'reference' => 'develop',
            'flags' => (object) ['production' => false],
            'code_switch_status' => 'RUNNING',
            'ssh_url'=>'ideapp.dev01@ideappdev01.ssh.gardens.acquia-sites.com'
        ];

        $response8 = new CodebaseEnvironmentResponse($environmentWithSshUrl);
        $this->assertEquals('ideapp.dev01@ideappdev01.ssh.gardens.acquia-sites.com', $response8->ssh_url);
    }
}
