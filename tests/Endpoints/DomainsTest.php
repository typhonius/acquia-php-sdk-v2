<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Domains;

class DomainsTest extends CloudApiTestCase
{

    public $properties = [
    'hostname',
    'flags',
    'environment',
    ];

    public function testGetDomains()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Domains/getAllDomains.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $domain = new Domains($client);
        $result = $domain->getAll('185f07c7-9c4f-407b-8968-67892ebcb38a');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\DomainsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\DomainResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetDomain()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Domains/getDomain.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $domain = new Domains($client);
        $result = $domain->get('185f07c7-9c4f-407b-8968-67892ebcb38a', 'example.com');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\DomainResponse', $result);
        $this->assertEquals('example.com', $result->hostname);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testDomainAdd()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Domains/createDomain.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $domain = new Domains($client);
        $result = $domain->create('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 'new-domain.com');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals("The domain 'new-domain.com' is being added.", $result->message);
    }

    public function testDomainDelete()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Domains/deleteDomain.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $domain = new Domains($client);
        $result = $domain->delete('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 'deleted-domain.com');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals("Removing the domain deleted-domain.com", $result->message);
    }
}
