<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Databases;
use AcquiaCloudApi\Endpoints\DatabaseBackups;

class OperationTest extends CloudApiTestCase
{

    public $properties = [
        'message',
        'notificationUuid',
        'links',
    ];

    public function testOperationResponseWithHeaders()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Databases/createDatabases.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $databases = new Databases($client);
        $result = $databases->create('8ff6c046-ec64-4ce4-bea6-27845ec18600', 'db_name');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('The database is being created.', $result->message);
        $this->assertEquals(['c936a375-4bb8-422d-9d05-a3ff352646f7'], $result->notificationUuid);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }
}
