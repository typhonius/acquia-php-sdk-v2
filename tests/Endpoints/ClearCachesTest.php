<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Domains;

class ClearCachesTest extends CloudApiTestCase
{

    public function testClearCache(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Domains/clearCaches.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $domain = new Domains($client);
        $result = $domain->clearDomainCache(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            'example.com'
        );

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Caches are being cleared.', $result->message);
    }

    public function testClearCaches(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Domains/clearCaches.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $domain = new Domains($client);
        $result = $domain->purge(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            ['example.com', 'www.example.com']
        );

        $requestOptions = [
            'json' => [
                'domains' => ['example.com', 'www.example.com'],
            ],
        ];
        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Caches are being cleared.', $result->message);
    }
}
