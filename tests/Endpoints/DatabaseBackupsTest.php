<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\DatabaseBackups;
use AcquiaCloudApi\Response\BackupResponse;
use AcquiaCloudApi\Response\BackupsResponse;

class DatabaseBackupsTest extends CloudApiTestCase
{
    public function testDatabaseBackup(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/DatabaseBackups/createDatabaseBackup.json');
        $client = $this->getMockClient($response);

        $databaseBackup = new DatabaseBackups($client);
        $result = $databaseBackup->create('185f07c7-9c4f-407b-8968-67892ebcb38a', 'db_name');

        $this->assertEquals('Creating the backup.', $result->message);
    }

    public function testGetDatabaseBackups(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/DatabaseBackups/getAllDatabaseBackups.json');
        $client = $this->getMockClient($response);

        $databaseBackup = new DatabaseBackups($client);
        $result = $databaseBackup->getAll('185f07c7-9c4f-407b-8968-67892ebcb38a', 'db_name');

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(BackupResponse::class, $record);
        }
    }

    public function testGetDatabaseBackup(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/DatabaseBackups/getDatabaseBackup.json');
        $client = $this->getMockClient($response);

        $databaseBackup = new DatabaseBackups($client);
        $result = $databaseBackup->get('24-a47ac10b-58cc-4372-a567-0e02b2c3d470', 'db_name', 12);

        $this->assertNotInstanceOf(BackupsResponse::class, $result);
    }

    public function testRestoreDatabaseBackup(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/DatabaseBackups/restoreDatabaseBackup.json');
        $client = $this->getMockClient($response);

        $databaseBackup = new DatabaseBackups($client);
        $result = $databaseBackup->restore('24-a47ac10b-58cc-4372-a567-0e02b2c3d470', 'db_name', 12);

        $this->assertEquals('Restoring the database backup.', $result->message);
    }

    public function testDownloadDatabaseBackup(): void
    {
        $response = $this->getPsr7GzipResponseForFixture('Endpoints/DatabaseBackups/downloadDatabaseBackup.dat');
        $client = $this->getMockClient($response);

        $databaseBackup = new DatabaseBackups($client);
        $result = $databaseBackup->download('12-d314739e-296f-11e9-b210-d663bd873d93', 'my_db', 1);

        $headers = $response->getHeader('Content-Type');
        $this->assertEquals('application/octet-stream', reset($headers));

        $this->assertNotInstanceOf(\ArrayObject::class, $result);
    }

    public function testDeleteDatabaseBackup(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/DatabaseBackups/deleteDatabaseBackup.json');
        $client = $this->getMockClient($response);

        $databaseBackup = new DatabaseBackups($client);
        $result = $databaseBackup->delete('185f07c7-9c4f-407b-8968-67892ebcb38a', 'db_name', 1234);

        $this->assertEquals('Deleting the database backup.', $result->message);
    }
}
