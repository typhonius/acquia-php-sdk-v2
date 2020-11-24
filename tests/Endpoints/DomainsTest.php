<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Domains;

class DomainsTest extends CloudApiTestCase
{
    /**
     * @var mixed[] $properties
     */
    public $properties = [
        'hostname',
        'flags',
        'environment',
    ];

    /**
     * @var mixed[] $metricsProperties
     */
    public $metricsProperties = [
        'metric',
        'datapoints',
        'last_data_at',
        'metadata',
        'links'
    ];

    public function testGetDomains(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Domains/getAllDomains.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $domain = new Domains($client);
        $result = $domain->getAll('185f07c7-9c4f-407b-8968-67892ebcb38a');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\DomainsResponse', $result);
        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\DomainResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetDomain(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Domains/getDomain.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $domain = new Domains($client);
        $result = $domain->get('185f07c7-9c4f-407b-8968-67892ebcb38a', 'example.com');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\DomainResponse', $result);
        $this->assertEquals('example.com', $result->hostname);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testDomainAdd(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Domains/createDomain.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $domain = new Domains($client);
        $result = $domain->create('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 'new-domain.com');

        $requestOptions = [
            'json' => [
                'hostname' => 'new-domain.com',
            ],
        ];

        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals("Adding domain example.com", $result->message);
    }

    public function testDomainDelete(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Domains/deleteDomain.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $domain = new Domains($client);
        $result = $domain->delete('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 'deleted-domain.com');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals("Removing the domain example.com", $result->message);
    }

    public function testDomainStatus(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Domains/getDomainStatus.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $domain = new Domains($client);
        $result = $domain->status('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 'domain.com');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\DomainResponse', $result);
        $this->assertEquals('example.com', $result->hostname);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testDomainMetrics(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Domains/getDomainMetrics.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $domain = new Domains($client);
        $result = $domain->metrics('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 'example.com');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\MetricsResponse', $result);
        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\MetricResponse', $record);

            foreach ($this->metricsProperties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }
}
