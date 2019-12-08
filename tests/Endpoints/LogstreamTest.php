<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Logs;

class LogstreamTest extends CloudApiTestCase
{

    public $properties = [
    'logstream',
    'links'
    ];

    public function testGetLogstream()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getLogstream.json');

        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $logs = new Logs($client);
        $result = $logs->stream('24-a47ac10b-58cc-4372-a567-0e02b2c3d470');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\LogstreamResponse', $result);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }
}
