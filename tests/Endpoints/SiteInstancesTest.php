<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\SiteInstances;
use AcquiaCloudApi\Response\SiteInstanceResponse;
use AcquiaCloudApi\Response\SiteInstanceDatabaseResponse;
use AcquiaCloudApi\Response\BackupResponse;
use AcquiaCloudApi\Response\BackupsResponse;
use AcquiaCloudApi\Response\DomainResponse;
use AcquiaCloudApi\Response\DomainsResponse;
use AcquiaCloudApi\Response\OperationResponse;

class SiteInstancesTest extends CloudApiTestCase
{
    public function testGetSiteInstance(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SiteInstances/getSiteInstance.json');
        $client = $this->getMockClient($response);

        $siteInstances = new SiteInstances($client);
        $result = $siteInstances->get('3e8ecbec-ea7c-4260-8414-ef2938c859bc', 'd3f7270e-c45f-4801-9308-5e8afe84a323');

        $this->assertInstanceOf(SiteInstanceResponse::class, $result);
        $this->assertEquals('3e8ecbec-ea7c-4260-8414-ef2938c859bc', $result->siteId);
        $this->assertEquals('d3f7270e-c45f-4801-9308-5e8afe84a323', $result->environmentId);
        $this->assertEquals('active', $result->status);
        $this->assertEquals('example-site', $result->name);
        $this->assertEquals('Example Site', $result->label);
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
        $this->assertNotNull($result->siteId);
        $this->assertNotNull($result->environmentId);
        $this->assertNotNull($result->status);
        $this->assertIsObject($result->links);
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
}
