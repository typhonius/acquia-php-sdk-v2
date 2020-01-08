<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Logs;

class LogsTest extends CloudApiTestCase
{

    public $properties = [
    'type',
    'label',
    'flags',
    'links'
    ];

    public $logstreamProperties = [
    'logstream',
    'links'
    ];

    public function testGetLogs()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Logs/getAllLogs.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $logs = new Logs($client);
        $result = $logs->getAll('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\LogsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\LogResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testLogSnapshot()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Logs/createLogSnapshot.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $logs = new Logs($client);
        $result = $logs->snapshot('r47ac10b-58cc-4372-a567-0e02b2c3d470', 'php-error');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('The log file is being created.', $result->message);
    }

    public function testDownloadLog()
    {
        $response = $this->getPsr7GzipResponseForFixture('Endpoints/Logs/downloadLog.dat');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $logs = new Logs($client);
        $result = $logs->download('8ff6c046-ec64-4ce4-bea6-27845ec18600', 'php-error');

        $headers = $response->getHeader('Content-Type');
        $this->assertEquals('application/octet-stream', reset($headers));

        $this->assertNotInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('GuzzleHttp\Psr7\Stream', $result);
    }


    public function testGetLogstream()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Logs/getLogstream.json');

        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $logs = new Logs($client);
        $result = $logs->stream('24-a47ac10b-58cc-4372-a567-0e02b2c3d470');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\LogstreamResponse', $result);

        foreach ($this->logstreamProperties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }
}
