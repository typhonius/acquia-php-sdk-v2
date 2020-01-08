<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Databases;
use AcquiaCloudApi\Endpoints\DatabaseBackups;

class DatabaseBackupsTest extends CloudApiTestCase
{

    public $properties = [
        'id',
        'database',
        'type',
        'startedAt',
        'completedAt',
        'flags',
        'environment',
        'links',
    ];

    public function testDatabaseBackup()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/DatabaseBackups/createDatabaseBackup.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $databaseBackup = new DatabaseBackups($client);
        $result = $databaseBackup->create('185f07c7-9c4f-407b-8968-67892ebcb38a', 'db_name');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Creating the backup.', $result->message);
    }

    public function testGetDatabaseBackups()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/DatabaseBackups/getAllDatabaseBackups.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $databaseBackup = new DatabaseBackups($client);
        $result = $databaseBackup->getAll('185f07c7-9c4f-407b-8968-67892ebcb38a', 'db_name');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\BackupsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\BackupResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetDatabaseBackup()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/DatabaseBackups/getDatabaseBackup.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $databaseBackup = new DatabaseBackups($client);
        $result = $databaseBackup->get('24-a47ac10b-58cc-4372-a567-0e02b2c3d470', 'db_name', 12);

        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\BackupsResponse', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\BackupResponse', $result);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testRestoreDatabaseBackup()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/DatabaseBackups/restoreDatabaseBackup.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $databaseBackup = new DatabaseBackups($client);
        $result = $databaseBackup->restore('24-a47ac10b-58cc-4372-a567-0e02b2c3d470', 'db_name', 12);

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Restoring the database backup.', $result->message);
    }
}
