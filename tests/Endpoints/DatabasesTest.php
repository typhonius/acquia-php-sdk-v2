<?php

class DatabasesTest extends CloudApiTestCase
{

    public $properties = [
        'name',
    ];

    public $backupProperties = [
        'id',
        'database',
        'type',
        'startedAt',
        'completedAt',
        'flags',
        'environment',
        'links',
    ];

    public function testGetDatabases()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getDatabases.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->databases('185f07c7-9c4f-407b-8968-67892ebcb38a');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\DatabasesResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\DatabaseResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetEnvironmentDatabases()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getEnvironmentDatabases.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->environmentDatabases('24-a47ac10b-58cc-4372-a567-0e02b2c3d470');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\DatabasesResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\DatabaseResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testDatabaseCopy()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/copyDatabases.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->databaseCopy('24-a47ac10b-58cc-4372-a567-0e02b2c3d470', 'db_name', '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('The database is queued for copying.', $result->message);
    }

    public function testDatabaseCreate()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/createDatabases.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->databaseCreate('8ff6c046-ec64-4ce4-bea6-27845ec18600', 'db_name');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('The database is being created.', $result->message);
    }

    public function testDatabaseDelete()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/deleteDatabases.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->databaseDelete('8ff6c046-ec64-4ce4-bea6-27845ec18600', 'db_name');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('The database is being deleted.', $result->message);
    }

    public function testDatabaseBackup()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/backupDatabases.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->createDatabaseBackup('185f07c7-9c4f-407b-8968-67892ebcb38a', 'db_name');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('The database is being backed up.', $result->message);
    }

    public function testGetDatabaseBackups()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getDatabaseBackups.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->databaseBackups('185f07c7-9c4f-407b-8968-67892ebcb38a', 'db_name');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\BackupsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\BackupResponse', $record);

            foreach ($this->backupProperties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetDatabaseBackup()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getDatabaseBackup.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->databaseBackup('24-a47ac10b-58cc-4372-a567-0e02b2c3d470', 12);

        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\BackupsResponse', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\BackupResponse', $result);

        foreach ($this->backupProperties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testRestoreDatabaseBackup()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/restoreDatabaseBackup.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->restoreDatabaseBackup('24-a47ac10b-58cc-4372-a567-0e02b2c3d470', 12);

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('The backup is being restored.', $result->message);
    }
}
