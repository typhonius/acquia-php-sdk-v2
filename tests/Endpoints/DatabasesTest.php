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

        $response = (array) $this->generateCloudApiResponse('Endpoints/getDatabases.json');
        $databases = new \AcquiaCloudApi\Response\DatabasesResponse($response);


        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['databases'])
        ->getMock();
        $client->expects($this->once())
        ->method('databases')
          ->with('185f07c7-9c4f-407b-8968-67892ebcb38a')
          ->will($this->returnValue($databases));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
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
        $response = $this->generateCloudApiResponse('Endpoints/getEnvironmentDatabases.json');

        $databases = new \AcquiaCloudApi\Response\DatabasesResponse($response);

        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['environmentDatabases'])
        ->getMock();

        $client->expects($this->once())
        ->method('environmentDatabases')
        ->with('24-a47ac10b-58cc-4372-a567-0e02b2c3d470')
        ->will($this->returnValue($databases));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
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
        $response = $this->generateCloudApiResponse('Endpoints/copyDatabases.json');

        $message = new \AcquiaCloudApi\Response\OperationResponse($response);

        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['databaseCopy'])
        ->getMock();

        $client->expects($this->once())
        ->method('databaseCopy')
        ->with('24-a47ac10b-58cc-4372-a567-0e02b2c3d470', 'db_name', '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851')
        ->will($this->returnValue($message));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->databaseCopy(
            '24-a47ac10b-58cc-4372-a567-0e02b2c3d470',
            'db_name',
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851'
        );
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('The database is queued for copying.', $result->message);
    }

    public function testDatabaseCreate()
    {
        $response = $this->generateCloudApiResponse('Endpoints/createDatabases.json');

        $message = new \AcquiaCloudApi\Response\OperationResponse($response);

        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['databaseCreate'])
        ->getMock();

        $client->expects($this->once())
        ->method('databaseCreate')
        ->with('8ff6c046-ec64-4ce4-bea6-27845ec18600', 'db_name')
        ->will($this->returnValue($message));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->databaseCreate('8ff6c046-ec64-4ce4-bea6-27845ec18600', 'db_name');
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('The database is being created.', $result->message);
    }

    public function testDatabaseDelete()
    {
        $response = $this->generateCloudApiResponse('Endpoints/deleteDatabases.json');

        $message = new \AcquiaCloudApi\Response\OperationResponse($response);

        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['databaseDelete'])
        ->getMock();

        $client->expects($this->once())
        ->method('databaseDelete')
        ->with('8ff6c046-ec64-4ce4-bea6-27845ec18600', 'db_name')
        ->will($this->returnValue($message));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->databaseDelete('8ff6c046-ec64-4ce4-bea6-27845ec18600', 'db_name');
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('The database is being deleted.', $result->message);
    }

    public function testDatabaseBackup()
    {
        $response = $this->generateCloudApiResponse('Endpoints/backupDatabases.json');

        $message = new \AcquiaCloudApi\Response\OperationResponse($response);

        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['databaseBackup'])
        ->getMock();

        $client->expects($this->once())
        ->method('databaseBackup')
        ->with('8ff6c046-ec64-4ce4-bea6-27845ec18600', 'db_name')
        ->will($this->returnValue($message));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->databaseBackup('8ff6c046-ec64-4ce4-bea6-27845ec18600', 'db_name');
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('The database is being backed up.', $result->message);
    }

    public function testGetDatabaseBackups()
    {
        $response = $this->generateCloudApiResponse('Endpoints/getDatabaseBackups.json');

        $backups = new \AcquiaCloudApi\Response\BackupsResponse($response);

        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['databaseBackups'])
        ->getMock();

        $client->expects($this->once())
        ->method('databaseBackups')
        ->with('185f07c7-9c4f-407b-8968-67892ebcb38a', 'db_name')
        ->will($this->returnValue($backups));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
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
        $response = $this->generateCloudApiResponse('Endpoints/getDatabaseBackup.json');

        $backups = new \AcquiaCloudApi\Response\BackupResponse($response);

        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['databaseBackupInfo'])
        ->getMock();

        $client->expects($this->once())
        ->method('databaseBackupInfo')
        ->with('24-a47ac10b-58cc-4372-a567-0e02b2c3d470', 2)
        ->will($this->returnValue($backups));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->databaseBackupInfo('24-a47ac10b-58cc-4372-a567-0e02b2c3d470', 2);

        $this->assertNotInstanceOf('\ArrayObject', $result);
        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\BackupsResponse', $result);

        $this->assertInstanceOf('\AcquiaCloudApi\Response\BackupResponse', $result);

        foreach ($this->backupProperties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }
}
