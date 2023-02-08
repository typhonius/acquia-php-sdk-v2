<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Logs;
use AcquiaCloudApi\Response\LogResponse;

class LogsTest extends CloudApiTestCase
{
    public function testGetLogs(): void
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Logs/getAllLogs.json');
        $client = $this->getMockClient($response);

        $logs = new Logs($client);
        $result = $logs->getAll('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(LogResponse::class, $record);
        }
    }

    public function testLogSnapshot(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Logs/createLogSnapshot.json');
        $client = $this->getMockClient($response);

        $logs = new Logs($client);
        $result = $logs->snapshot('r47ac10b-58cc-4372-a567-0e02b2c3d470', 'php-error');

        $this->assertEquals('The log file is being created.', $result->message);
    }

    public function testDownloadLog(): void
    {
        $response = $this->getPsr7GzipResponseForFixture('Endpoints/Logs/downloadLog.dat');
        $client = $this->getMockClient($response);

        $logs = new Logs($client);
        $result = $logs->download('8ff6c046-ec64-4ce4-bea6-27845ec18600', 'php-error');

        $headers = $response->getHeader('Content-Type');
        $this->assertEquals('application/octet-stream', reset($headers));

        $this->assertNotInstanceOf(\ArrayObject::class, $result);
    }


    public function testGetLogstream(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Logs/getLogstream.json');

        $client = $this->getMockClient($response);

        $logs = new Logs($client);
        $logs->stream('24-a47ac10b-58cc-4372-a567-0e02b2c3d470');
    }
}
