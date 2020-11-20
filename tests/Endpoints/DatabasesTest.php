<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Databases;
use AcquiaCloudApi\Endpoints\DatabaseBackups;

class DatabasesTest extends CloudApiTestCase
{
    /**
     * @var mixed[] $properties
     */
    public $properties = [
        'name',
    ];

    public function testGetApplicationDatabases(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Databases/getAllDatabases.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $databases = new Databases($client);
        $result = $databases->getAll('185f07c7-9c4f-407b-8968-67892ebcb38a');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\DatabasesResponse', $result);
        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\DatabaseResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testDatabaseCopy(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Databases/copyDatabases.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $databases = new Databases($client);
        $result = $databases->copy(
            '24-a47ac10b-58cc-4372-a567-0e02b2c3d470',
            'db_name',
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851'
        );

        $requestOptions = [
            'json' => [
                'name' => 'db_name',
                'source' => '24-a47ac10b-58cc-4372-a567-0e02b2c3d470',
            ],
        ];

        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('The database is being copied', $result->message);
    }

    public function testDatabaseCreate(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Databases/createDatabases.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $databases = new Databases($client);
        $result = $databases->create('8ff6c046-ec64-4ce4-bea6-27845ec18600', 'db_name');

        $requestOptions = [
            'json' => [
                'name' => 'db_name',
            ],
        ];

        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('The database is being created.', $result->message);
    }

    public function testDatabaseDelete(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Databases/deleteDatabases.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $databases = new Databases($client);
        $result = $databases->delete('8ff6c046-ec64-4ce4-bea6-27845ec18600', 'db_name');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('The database is being deleted.', $result->message);
    }

    public function testDatabasesTruncate(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Databases/truncateDatabases.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $databases = new Databases($client);
        $result = $databases->truncate('da1c0a8e-ff69-45db-88fc-acd6d2affbb7', 'drupal8');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('The database is being erased.', $result->message);
    }
}
