<?php

use AcquiaCloudApi\CloudApi\Client;

class DrushTest extends CloudApiTestCase
{

    public function testGetApplications()
    {
        $response = $this->getPsr7GzipResponseForFixture('Endpoints/getDrushAliases.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->drushAliases();

        $headers = $response->getHeader('Content-Type');
        $this->assertEquals('application/gzip', reset($headers));

        $this->assertNotInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('GuzzleHttp\Psr7\Stream', $result);
    }
}
