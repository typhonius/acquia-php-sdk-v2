<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;

class DomainsTest extends CloudApiTestCase
{

    public $properties = [
    'hostname',
    'flags',
    'environment',
    ];

    public function testGetDomains()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getDomains.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->domains('185f07c7-9c4f-407b-8968-67892ebcb38a');

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
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getDomain.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->domain('185f07c7-9c4f-407b-8968-67892ebcb38a', 'example.com');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\DomainResponse', $result);
        $this->assertEquals('example.com', $result->hostname);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testDomainAdd()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/addDomain.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->createDomain('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 'example.com');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertOperationResponse($result);
        $this->assertEquals("Adding domain example.com", $result->message);
    }

    public function testDomainDelete()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/deleteDomain.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->deleteDomain('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 'example.com');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertOperationResponse($result);
        $this->assertEquals("Removing the domain example.com", $result->message);
    }
}
