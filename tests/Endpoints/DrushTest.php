<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Account;

class DrushTest extends CloudApiTestCase
{

    public function testGetDrushAliases(): void
    {
        $response = $this->getPsr7GzipResponseForFixture('Endpoints/Account/getDrushAliases.dat');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $account = new Account($client);
        $result = $account->getDrushAliases();

        $headers = $response->getHeader('Content-Type');
        $this->assertEquals('application/octet-stream', reset($headers));

        $this->assertNotInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('GuzzleHttp\Psr7\Stream', $result);
    }
}
