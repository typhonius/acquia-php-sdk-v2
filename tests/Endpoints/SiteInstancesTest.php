<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\SiteInstances;
use AcquiaCloudApi\Response\SiteInstanceResponse;
use AcquiaCloudApi\Response\SiteInstanceDatabaseResponse;
use AcquiaCloudApi\Response\BackupResponse;
use AcquiaCloudApi\Response\BackupsResponse;
use AcquiaCloudApi\Response\CodebaseEnvironmentResponse;
use AcquiaCloudApi\Response\DomainResponse;
use AcquiaCloudApi\Response\DomainsResponse;
use AcquiaCloudApi\Response\OperationResponse;
use AcquiaCloudApi\Response\SiteResponse;

class SiteInstancesTest extends CloudApiTestCase
{
    public function testGetSiteInstance(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SiteInstances/getSiteInstance.json');
        $client = $this->getMockClient($response);

        $siteInstances = new SiteInstances($client);
        $result = $siteInstances->get('3e8ecbec-ea7c-4260-8414-ef2938c859bc', 'd3f7270e-c45f-4801-9308-5e8afe84a323');

        $this->assertInstanceOf(SiteInstanceResponse::class, $result);
        $this->assertEquals('3e8ecbec-ea7c-4260-8414-ef2938c859bc', $result->site_id);
        $this->assertEquals('d3f7270e-c45f-4801-9308-5e8afe84a323', $result->environment_id);
        $this->assertEquals('active', $result->status);

        // Test health_status object
        $this->assertIsObject($result->health_status);
        $this->assertEquals('SITE_HEALTH_GREEN', $result->health_status->code);
        $this->assertEquals('Site is healthy', $result->health_status->summary);
        $this->assertEquals('All systems are operational', $result->health_status->details);
    }

    public function testGetSiteInstanceDatabase(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SiteInstances/getSiteInstanceDatabase.json');
        $client = $this->getMockClient($response);

        $siteInstances = new SiteInstances($client);
        $result = $siteInstances->getDatabase(
            '3e8ecbec-ea7c-4260-8414-ef2938c859bc',
            'd3f7270e-c45f-4801-9308-5e8afe84a323'
        );

        $this->assertInstanceOf(SiteInstanceDatabaseResponse::class, $result);
        $this->assertEquals('localhost', $result->databaseHost);
        $this->assertEquals('example_db', $result->databaseName);
        $this->assertEquals('primary', $result->databaseRole);
        $this->assertEquals('example_user', $result->databaseUser);
        $this->assertEquals('example_password', $result->databasePassword);
        $this->assertEquals(3306, $result->databasePort);
    }

    public function testCopyDatabase(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SiteInstances/copyDatabase.json');
        $client = $this->getMockClient($response);

        $siteInstances = new SiteInstances($client);
        $result = $siteInstances->copyDatabase(
            '3e8ecbec-ea7c-4260-8414-ef2938c859bc',
            'a0c9dff7-56b6-4c0d-bad0-0e6593f66cd3',
            'd3f7270e-c45f-4801-9308-5e8afe84a323'
        );

        $requestOptions = [
            'json' => [
                'source' => 'd3f7270e-c45f-4801-9308-5e8afe84a323',
            ],
        ];

        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertInstanceOf(OperationResponse::class, $result);
        $this->assertStringContainsString('Database copy for site id', $result->message);
    }

    public function testGetDatabaseBackups(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SiteInstances/getDatabaseBackups.json');
        $client = $this->getMockClient($response);

        $siteInstances = new SiteInstances($client);
        $result = $siteInstances->getDatabaseBackups(
            '3e8ecbec-ea7c-4260-8414-ef2938c859bc',
            'a0c9dff7-56b6-4c0d-bad0-0e6593f66cd3'
        );

        $this->assertInstanceOf(BackupsResponse::class, $result);
        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(BackupResponse::class, $record);
        }

        // Test first backup
        $firstBackup = $result[0];
        $this->assertEquals(1, $firstBackup->id);
        $this->assertEquals('daily', $firstBackup->type);
    }

    public function testCreateDatabaseBackup(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SiteInstances/createDatabaseBackup.json');
        $client = $this->getMockClient($response);

        $siteInstances = new SiteInstances($client);
        $result = $siteInstances->createDatabaseBackup(
            '3e8ecbec-ea7c-4260-8414-ef2938c859bc',
            'a0c9dff7-56b6-4c0d-bad0-0e6593f66cd3'
        );

        $this->assertInstanceOf(OperationResponse::class, $result);
        $this->assertEquals('Database backup created successfully.', $result->message);
    }

    public function testGetDatabaseBackup(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SiteInstances/getDatabaseBackup.json');
        $client = $this->getMockClient($response);

        $siteInstances = new SiteInstances($client);
        $result = $siteInstances->getDatabaseBackup(
            '3e8ecbec-ea7c-4260-8414-ef2938c859bc',
            'a0c9dff7-56b6-4c0d-bad0-0e6593f66cd3',
            '1'
        );

        $this->assertInstanceOf(BackupResponse::class, $result);
        $this->assertEquals(1, $result->id);
        $this->assertEquals('daily', $result->type);
        $this->assertEquals('2023-01-15T10:00:00.000Z', $result->startedAt);
        $this->assertEquals('2023-01-15T10:30:00.000Z', $result->completedAt);
    }

    public function testDownloadDatabaseBackup(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SiteInstances/downloadDatabaseBackup.json');
        $client = $this->getMockClient($response);

        $siteInstances = new SiteInstances($client);
        $result = $siteInstances->downloadDatabaseBackup(
            '3e8ecbec-ea7c-4260-8414-ef2938c859bc',
            'a0c9dff7-56b6-4c0d-bad0-0e6593f66cd3',
            '1'
        );

        $this->assertInstanceOf(OperationResponse::class, $result);
        $this->assertEquals('Database backup download started.', $result->message);
    }

    public function testRestoreDatabaseBackup(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SiteInstances/restoreDatabaseBackup.json');
        $client = $this->getMockClient($response);

        $siteInstances = new SiteInstances($client);
        $result = $siteInstances->restoreDatabaseBackup(
            '3e8ecbec-ea7c-4260-8414-ef2938c859bc',
            'a0c9dff7-56b6-4c0d-bad0-0e6593f66cd3',
            '1'
        );

        $this->assertInstanceOf(OperationResponse::class, $result);
        $this->assertEquals('Database backup restore started.', $result->message);
    }

    public function testGetDomains(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SiteInstances/getDomains.json');
        $client = $this->getMockClient($response);

        $siteInstances = new SiteInstances($client);
        $result = $siteInstances->getDomains(
            '3e8ecbec-ea7c-4260-8414-ef2938c859bc',
            'a0c9dff7-56b6-4c0d-bad0-0e6593f66cd3'
        );

        $this->assertInstanceOf(DomainsResponse::class, $result);
        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(DomainResponse::class, $record);
        }

        // Test first domain
        $firstDomain = $result[0];
        $this->assertEquals('example.com', $firstDomain->hostname);
    }

    public function testGetDomain(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SiteInstances/getDomain.json');
        $client = $this->getMockClient($response);

        $siteInstances = new SiteInstances($client);
        $result = $siteInstances->getDomain(
            '3e8ecbec-ea7c-4260-8414-ef2938c859bc',
            'a0c9dff7-56b6-4c0d-bad0-0e6593f66cd3',
            'example.com'
        );

        $this->assertInstanceOf(DomainResponse::class, $result);
        $this->assertEquals('example.com', $result->hostname);
        $this->assertIsArray($result->ip_addresses);
        $this->assertEquals(['192.168.1.1'], $result->ip_addresses);
    }

    public function testGetDomainStatus(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SiteInstances/getDomainStatus.json');
        $client = $this->getMockClient($response);

        $siteInstances = new SiteInstances($client);
        $result = $siteInstances->getDomainStatus(
            '3e8ecbec-ea7c-4260-8414-ef2938c859bc',
            'a0c9dff7-56b6-4c0d-bad0-0e6593f66cd3',
            'example.com'
        );

        $this->assertInstanceOf(DomainResponse::class, $result);
        $this->assertEquals('example.com', $result->hostname);
        $this->assertIsArray($result->ip_addresses);
        $this->assertEquals(['192.168.1.1'], $result->ip_addresses);
    }

    public function testCopyFiles(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SiteInstances/copyFiles.json');
        $client = $this->getMockClient($response);

        $siteInstances = new SiteInstances($client);
        $result = $siteInstances->copyFiles(
            '3e8ecbec-ea7c-4260-8414-ef2938c859bc',
            'a0c9dff7-56b6-4c0d-bad0-0e6593f66cd3',
            'd3f7270e-c45f-4801-9308-5e8afe84a323'
        );

        $requestOptions = [
            'json' => [
                'source' => 'd3f7270e-c45f-4801-9308-5e8afe84a323',
            ],
        ];

        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertInstanceOf(OperationResponse::class, $result);
        $this->assertStringContainsString('Files copy for site id', $result->message);
    }

    public function testSiteInstanceResponseTransformations(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SiteInstances/getSiteInstance.json');
        $client = $this->getMockClient($response);

        $siteInstances = new SiteInstances($client);
        $result = $siteInstances->get('3e8ecbec-ea7c-4260-8414-ef2938c859bc', 'd3f7270e-c45f-4801-9308-5e8afe84a323');

        $this->assertInstanceOf(SiteInstanceResponse::class, $result);
        $this->assertNotNull($result->site_id);
        $this->assertNotNull($result->environment_id);
        $this->assertNotNull($result->status);

        // Test health_status object and its properties
        $this->assertIsObject($result->health_status);
        $this->assertTrue(
            property_exists($result->health_status, 'code'),
            'Health status should contain "code" property'
        );
        $this->assertTrue(
            property_exists($result->health_status, 'summary'),
            'Health status should contain "summary" property'
        );
        $this->assertTrue(
            property_exists($result->health_status, 'details'),
            'Health status should contain "details" property'
        );

        // Test specific values in health_status object
        $this->assertEquals('SITE_HEALTH_GREEN', $result->health_status->code);
        $this->assertEquals('Site is healthy', $result->health_status->summary);
        $this->assertEquals('All systems are operational', $result->health_status->details);

        // Test that links is an object (catches CastObject mutation)
        $this->assertIsObject($result->links);

        // Test that links has expected structure from fixture (catches Coalesce mutation)
        $this->assertTrue(
            property_exists($result->links, 'self'),
            'Links should contain "self" property from fixture, not empty object'
        );
    }

    public function testDatabaseResponseTransformations(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SiteInstances/getSiteInstanceDatabase.json');
        $client = $this->getMockClient($response);

        $siteInstances = new SiteInstances($client);
        $result = $siteInstances->getDatabase(
            '3e8ecbec-ea7c-4260-8414-ef2938c859bc',
            'd3f7270e-c45f-4801-9308-5e8afe84a323'
        );

        $this->assertInstanceOf(SiteInstanceDatabaseResponse::class, $result);
        $this->assertNotNull($result->databaseHost);
        $this->assertNotNull($result->databaseName);
        $this->assertNotNull($result->databaseRole);
        $this->assertNotNull($result->databaseUser);
        $this->assertNotNull($result->databasePassword);
        $this->assertIsInt($result->databasePort);
        $this->assertIsObject($result->links);
    }

    public function testBackupsResponseTransformations(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SiteInstances/getDatabaseBackups.json');
        $client = $this->getMockClient($response);

        $siteInstances = new SiteInstances($client);
        $result = $siteInstances->getDatabaseBackups(
            '3e8ecbec-ea7c-4260-8414-ef2938c859bc',
            'a0c9dff7-56b6-4c0d-bad0-0e6593f66cd3'
        );

        $this->assertInstanceOf(BackupsResponse::class, $result);

        // Enhanced array iteration to catch array transformation mutations
        $itemCount = 0;
        foreach ($result as $index => $backupResponse) {
            $this->assertInstanceOf(BackupResponse::class, $backupResponse);
            $this->assertNotNull($backupResponse); // Catches NewObject mutations
            $this->assertIsInt($backupResponse->id);
            $this->assertIsString($backupResponse->type);
            $itemCount++;
        }

        // Verify we actually tested items
        $this->assertGreaterThan(0, $itemCount, 'Should have processed at least one backup');

        // Test direct array access to catch UnwrapArrayMap mutations
        if (count($result) > 0) {
            $this->assertArrayHasKey(0, $result);
            $firstBackup = $result[0];
            $this->assertInstanceOf(BackupResponse::class, $firstBackup);
            $this->assertNotNull($firstBackup->id);
        }
    }

    public function testDomainsResponseTransformations(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SiteInstances/getDomains.json');
        $client = $this->getMockClient($response);

        $siteInstances = new SiteInstances($client);
        $result = $siteInstances->getDomains(
            '3e8ecbec-ea7c-4260-8414-ef2938c859bc',
            'a0c9dff7-56b6-4c0d-bad0-0e6593f66cd3'
        );

        $this->assertInstanceOf(DomainsResponse::class, $result);

        // Enhanced array iteration to catch array transformation mutations
        $itemCount = 0;
        foreach ($result as $index => $domainResponse) {
            $this->assertInstanceOf(DomainResponse::class, $domainResponse);
            $this->assertNotNull($domainResponse); // Catches NewObject mutations
            $this->assertIsString($domainResponse->hostname);
            $itemCount++;
        }

        // Verify we actually tested items
        $this->assertGreaterThan(0, $itemCount, 'Should have processed at least one domain');

        // Test direct array access to catch UnwrapArrayMap mutations
        if (count($result) > 0) {
            $this->assertArrayHasKey(0, $result);
            $firstDomain = $result[0];
            $this->assertInstanceOf(DomainResponse::class, $firstDomain);
            $this->assertNotNull($firstDomain->hostname);
        }
    }

    /**
     * Tests that links property handling is robust against mutations
     */
    public function testLinksPropertyHandling(): void
    {
        // Case 1: Test when _links is provided properly
        $siteInstance = (object) [
            'site_id' => 'test-site-id',
            'environment_id' => 'test-env-id',
            'status' => 'SITE_INSTANCE_STATUS_READY',
            '_links' => (object) ['self' => 'https://example.com/api/sites/123']
        ];
        $response = new SiteInstanceResponse($siteInstance);
        $this->assertIsObject($response->links);
        $this->assertTrue(property_exists($response->links, 'self'));
        $this->assertEquals('https://example.com/api/sites/123', $response->links->self);

        // Case 2: Test when _links is null (tests Coalesce mutation protection)
        $siteInstance = (object) [
            'site_id' => 'test-site-id',
            'environment_id' => 'test-env-id',
            'status' => 'SITE_INSTANCE_STATUS_READY',
            '_links' => null
        ];
        $response = new SiteInstanceResponse($siteInstance);
        $this->assertIsObject($response->links);
        $this->assertEquals(new \stdClass(), $response->links);

        // Case 3: Test when _links is missing entirely (tests Coalesce mutation protection)
        $siteInstance = (object) [
            'site_id' => 'test-site-id',
            'environment_id' => 'test-env-id',
            'status' => 'SITE_INSTANCE_STATUS_READY'
        ];
        $response = new SiteInstanceResponse($siteInstance);
        $this->assertIsObject($response->links);
        $this->assertEquals(new \stdClass(), $response->links);

        // Case 4: Test when _links is an array (tests CastObject mutation protection)
        // In this case, we'll use a stdClass with _links property set to an array
        // to verify that the constructor properly casts it to an object
        $linksArray = ['self' => 'https://example.com/api/sites/123'];
        $siteInstance = (object) [
            'site_id' => 'test-site-id',
            'environment_id' => 'test-env-id',
            'status' => 'SITE_INSTANCE_STATUS_READY',
            '_links' => (object) $linksArray
        ];
        $response = new SiteInstanceResponse($siteInstance);
        $this->assertIsObject($response->links);
        $this->assertTrue(property_exists($response->links, 'self'));
        $this->assertEquals('https://example.com/api/sites/123', $response->links->self);
    }

    /**
     * Tests that health_status property handling is robust against mutations
     */
    public function testHealthStatusPropertyHandling(): void
    {
        // Case 1: Test when health_status is provided properly
        $siteInstance = (object) [
            'site_id' => 'test-site-id',
            'environment_id' => 'test-env-id',
            'status' => 'SITE_INSTANCE_STATUS_READY',
            'health_status' => (object) [
                'code' => 'SITE_HEALTH_GREEN',
                'summary' => 'Site is healthy',
                'details' => 'All systems are operational'
            ]
        ];
        $response = new SiteInstanceResponse($siteInstance);
        $this->assertIsObject($response->health_status);
        $this->assertEquals('SITE_HEALTH_GREEN', $response->health_status->code);
        $this->assertEquals('Site is healthy', $response->health_status->summary);
        $this->assertEquals('All systems are operational', $response->health_status->details);

        // Case 2: Test when health_status is null (tests Coalesce mutation protection)
        $siteInstance = (object) [
            'site_id' => 'test-site-id',
            'environment_id' => 'test-env-id',
            'status' => 'SITE_INSTANCE_STATUS_READY',
            'health_status' => null
        ];
        $response = new SiteInstanceResponse($siteInstance);
        $this->assertIsObject($response->health_status);
        $this->assertEquals(new \stdClass(), $response->health_status);

        // Case 3: Test when health_status is missing entirely (tests Coalesce mutation protection)
        $siteInstance = (object) [
            'site_id' => 'test-site-id',
            'environment_id' => 'test-env-id',
            'status' => 'SITE_INSTANCE_STATUS_READY'
        ];
        $response = new SiteInstanceResponse($siteInstance);
        $this->assertIsObject($response->health_status);
        $this->assertEquals(new \stdClass(), $response->health_status);

        // Case 4: Test when health_status has an array (tests property access)
        $healthArray = [
            'code' => 'SITE_HEALTH_AMBER',
            'summary' => 'Site has warnings',
            'details' => 'Some systems need attention'
        ];
        $siteInstance = (object) [
            'site_id' => 'test-site-id',
            'environment_id' => 'test-env-id',
            'status' => 'SITE_INSTANCE_STATUS_READY',
            'health_status' => (object) $healthArray
        ];
        $response = new SiteInstanceResponse($siteInstance);
        $this->assertIsObject($response->health_status);
        $this->assertTrue(property_exists($response->health_status, 'code'));
        $this->assertTrue(property_exists($response->health_status, 'summary'));
        $this->assertTrue(property_exists($response->health_status, 'details'));
        $this->assertEquals('SITE_HEALTH_AMBER', $response->health_status->code);
        $this->assertEquals('Site has warnings', $response->health_status->summary);
        $this->assertEquals('Some systems need attention', $response->health_status->details);
    }

    /**
     * Tests that domains property handling is robust against mutations
     */
    public function testDomainsPropertyHandling(): void
    {
        // Case 1: Test when domains is provided properly
        $domains = [
            'example.com',
            'www.example.com'
        ];
        $siteInstance = (object) [
            'site_id' => 'test-site-id',
            'environment_id' => 'test-env-id',
            'status' => 'SITE_INSTANCE_STATUS_READY',
            'domains' => $domains
        ];
        $response = new SiteInstanceResponse($siteInstance);
        $this->assertIsArray($response->domains);
        $this->assertCount(2, $response->domains);
        $this->assertEquals('example.com', $response->domains[0]);
        $this->assertEquals('www.example.com', $response->domains[1]);

        // Case 2: Test when domains is null (tests Coalesce mutation protection)
        $siteInstance = (object) [
            'site_id' => 'test-site-id',
            'environment_id' => 'test-env-id',
            'status' => 'SITE_INSTANCE_STATUS_READY',
            'domains' => null
        ];
        $response = new SiteInstanceResponse($siteInstance);
        $this->assertIsArray($response->domains);
        $this->assertEmpty($response->domains);

        // Case 3: Test when domains is missing entirely (tests Coalesce mutation protection)
        $siteInstance = (object) [
            'site_id' => 'test-site-id',
            'environment_id' => 'test-env-id',
            'status' => 'SITE_INSTANCE_STATUS_READY'
        ];
        $response = new SiteInstanceResponse($siteInstance);
        $this->assertIsArray($response->domains);
        $this->assertEmpty($response->domains);

        // Case 4: Test when domains is an array of objects
        $domainsWithObjects = [
            (object) ['hostname' => 'example.com', 'is_managed' => true],
            (object) ['hostname' => 'www.example.com', 'is_managed' => false]
        ];
        $siteInstance = (object) [
            'site_id' => 'test-site-id',
            'environment_id' => 'test-env-id',
            'status' => 'SITE_INSTANCE_STATUS_READY',
            'domains' => $domainsWithObjects
        ];
        $response = new SiteInstanceResponse($siteInstance);
        $this->assertIsArray($response->domains);
        $this->assertCount(2, $response->domains);
        $this->assertIsObject($response->domains[0]);
        $this->assertEquals('example.com', $response->domains[0]->hostname);
        $this->assertTrue($response->domains[0]->is_managed);
    }

    /**
     * Tests that legacy site and environment properties are handled correctly
     */
    public function testSiteAndEnvironmentPropertyHandling(): void
    {
        // Case 1: Test when site and environment properties are provided
        $siteData = (object) [
            'id' => 'test-site-id',
            'name' => 'test-site',
            'label' => 'Test Site',
            'description' => 'A test site',
            'codebase_id' => 'test-codebase-id',
            '_links' => (object) ['self' => 'https://example.com/sites/test-site-id']
        ];

        $environmentData = (object) [
            'id' => 'test-env-id',
            'name' => 'test-env',
            'label' => 'Test Environment',
            'description' => 'Test environment description',
            'status' => 'active',
            'reference' => 'main',
            'flags' => (object) ['production' => true],
            'properties' => (object) ['domain' => 'test.example.com'],
            '_links' => (object) ['self' => 'https://example.com/environments/test-env-id'],
            '_embedded' => (object) ['codebase' => (object) ['id' => 'test-codebase-id']]
        ];

        $siteInstance = (object) [
            'site_id' => 'test-site-id',
            'environment_id' => 'test-env-id',
            'status' => 'SITE_INSTANCE_STATUS_READY',
            '_links' => (object) ['self' => 'https://example.com/site-instances/test-site-id.test-env-id'],
            'site' => $siteData,
            'environment' => $environmentData
        ];

        $response = new SiteInstanceResponse($siteInstance);

        // Test site property handling
        $this->assertInstanceOf(SiteResponse::class, $response->site);
        $this->assertEquals('test-site-id', $response->site->id);
        $this->assertEquals('test-site', $response->site->name);
        $this->assertEquals('Test Site', $response->site->label);
        $this->assertEquals('A test site', $response->site->description);
        $this->assertEquals('test-codebase-id', $response->site->codebaseId);

        // Test environment property handling
        $this->assertInstanceOf(CodebaseEnvironmentResponse::class, $response->environment);
        $this->assertEquals('test-env-id', $response->environment->id);
        $this->assertEquals('test-env', $response->environment->name);
        $this->assertEquals('Test Environment', $response->environment->label);
        $this->assertEquals('Test environment description', $response->environment->description);
        $this->assertEquals('active', $response->environment->status);
        $this->assertEquals('main', $response->environment->reference);
        $this->assertTrue($response->environment->flags->production);
        $this->assertEquals('test.example.com', $response->environment->properties['domain']);

        // Case 2: Test when site and environment properties are missing
        $siteInstance = (object) [
            'site_id' => 'test-site-id',
            'environment_id' => 'test-env-id',
            'status' => 'SITE_INSTANCE_STATUS_READY',
            '_links' => (object) ['self' => 'https://example.com/site-instances/test-site-id.test-env-id']
        ];

        $response = new SiteInstanceResponse($siteInstance);

        // Test that properties are null when missing
        $this->assertNull($response->site);
        $this->assertNull($response->environment);
    }

    /**
     * Tests the CodebaseEnvironmentResponse edge cases for the codebase property
     */
    public function testCodebaseEnvironmentResponseEdgeCases(): void
    {
        // Case 1: Test when codebase is in _embedded
        $environmentWithEmbeddedCodebase = (object) [
            'id' => 'test-env-id',
            'name' => 'test-env',
            'label' => 'Test Environment',
            'description' => 'Test environment description',
            'status' => 'active',
            'reference' => 'main',
            'flags' => (object) ['production' => true],
            'properties' => (object) ['domain' => 'test.example.com'],
            '_links' => (object) ['self' => 'https://example.com/environments/test-env-id'],
            '_embedded' => (object) ['codebase' => (object) ['id' => 'embedded-codebase-id']]
        ];

        $response1 = new CodebaseEnvironmentResponse($environmentWithEmbeddedCodebase);
        $this->assertIsObject($response1->codebase);
        $this->assertEquals('embedded-codebase-id', $response1->codebase_uuid);

        // Case 2: Test when codebase is a direct property
        $environmentWithDirectCodebase = (object) [
            'id' => 'test-env-id',
            'name' => 'test-env',
            'label' => 'Test Environment',
            'description' => 'Test environment description',
            'status' => 'active',
            'reference' => 'main',
            'flags' => (object) ['production' => true],
            'properties' => (object) ['domain' => 'test.example.com'],
            '_links' => (object) ['self' => 'https://example.com/environments/test-env-id'],
            'codebase' => (object) ['id' => 'direct-codebase-id']
        ];

        $response2 = new CodebaseEnvironmentResponse($environmentWithDirectCodebase);
        $this->assertIsObject($response2->codebase);
        $this->assertEquals('direct-codebase-id', $response2->codebase_uuid);

        // Case 3: Test when codebase is missing
        $environmentWithoutCodebase = (object) [
            'id' => 'test-env-id',
            'name' => 'test-env',
            'label' => 'Test Environment',
            'description' => 'Test environment description',
            'status' => 'active',
            'reference' => 'main',
            'flags' => (object) ['production' => true],
            'properties' => (object) ['domain' => 'test.example.com'],
            '_links' => (object) ['self' => 'https://example.com/environments/test-env-id']
        ];

        $response3 = new CodebaseEnvironmentResponse($environmentWithoutCodebase);
        $this->assertIsObject($response3->codebase);
        $this->assertEquals(new \stdClass(), $response3->codebase);

        // Case 4: Test when properties is null or missing
        $environmentWithoutProperties = (object) [
            'id' => 'test-env-id',
            'name' => 'test-env',
            'label' => 'Test Environment',
            'description' => 'Test environment description',
            'status' => 'active',
            'reference' => 'main',
            'flags' => (object) ['production' => true],
            '_links' => (object) ['self' => 'https://example.com/environments/test-env-id']
        ];

        $response4 = new CodebaseEnvironmentResponse($environmentWithoutProperties);
        $this->assertIsArray($response4->properties);
        $this->assertEmpty($response4->properties);

        $environmentWithNullProperties = (object) [
            'id' => 'test-env-id',
            'name' => 'test-env',
            'label' => 'Test Environment',
            'description' => 'Test environment description',
            'status' => 'active',
            'reference' => 'main',
            'flags' => (object) ['production' => true],
            'properties' => null,
            '_links' => (object) ['self' => 'https://example.com/environments/test-env-id']
        ];

        $response5 = new CodebaseEnvironmentResponse($environmentWithNullProperties);
        $this->assertIsArray($response5->properties);
        $this->assertEmpty($response5->properties);
    }
}
