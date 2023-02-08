<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Domains;
use AcquiaCloudApi\Response\DomainResponse;
use AcquiaCloudApi\Response\MetricResponse;

class DomainsTest extends CloudApiTestCase
{
    public function testGetDomains(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Domains/getAllDomains.json');
        $client = $this->getMockClient($response);

        $domain = new Domains($client);
        $result = $domain->getAll('185f07c7-9c4f-407b-8968-67892ebcb38a');

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(DomainResponse::class, $record);
        }
    }

    public function testGetDomain(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Domains/getDomain.json');
        $client = $this->getMockClient($response);

        $domain = new Domains($client);
        $result = $domain->get('185f07c7-9c4f-407b-8968-67892ebcb38a', 'example.com');

        $this->assertEquals('example.com', $result->hostname);
    }

    public function testDomainAdd(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Domains/createDomain.json');
        $client = $this->getMockClient($response);

        $domain = new Domains($client);
        $result = $domain->create('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 'new-domain.com');

        $requestOptions = [
            'json' => [
                'hostname' => 'new-domain.com',
            ],
        ];

        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals("Adding domain example.com", $result->message);
    }

    public function testDomainDelete(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Domains/deleteDomain.json');
        $client = $this->getMockClient($response);

        $domain = new Domains($client);
        $result = $domain->delete('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 'deleted-domain.com');

        $this->assertEquals("Removing the domain example.com", $result->message);
    }

    public function testDomainStatus(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Domains/getDomainStatus.json');
        $client = $this->getMockClient($response);

        $domain = new Domains($client);
        $result = $domain->status('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 'domain.com');

        $this->assertEquals('example.com', $result->hostname);
    }

    public function testDomainMetrics(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Domains/getDomainMetrics.json');
        $client = $this->getMockClient($response);

        $domain = new Domains($client);
        $result = $domain->metrics('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 'example.com');

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(MetricResponse::class, $record);
        }
    }
}
