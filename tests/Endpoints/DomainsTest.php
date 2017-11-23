<?php

class DomainsTest extends CloudApiTestCase
{

    public $properties = [
    'hostname',
    'flags',
    'environment',
    ];

    public function testGetDomains()
    {

        $response = $this->generateCloudApiResponse('Endpoints/getDomains.json');
        $domains = new \AcquiaCloudApi\Response\DomainsResponse($response);


        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['domains'])
        ->getMock();
        $client->expects($this->once())
        ->method('domains')
        ->with('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851')
        ->will($this->returnValue($domains));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->domains('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\DomainsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\DomainResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testDomainAdd()
    {
        $response = $this->generateCloudApiResponse('Endpoints/addDomain.json');

        $message = new \AcquiaCloudApi\Response\OperationResponse($response);

        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['createDomain'])
        ->getMock();

        $client->expects($this->once())
        ->method('createDomain')
        ->with('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 'new-domain.com')
        ->will($this->returnValue($message));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->createDomain('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 'new-domain.com');
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals("The domain 'new-domain.com' is being added.", $result->message);
    }

    public function testDomainDelete()
    {
        $response = $this->generateCloudApiResponse('Endpoints/deleteDomain.json');

        $message = new \AcquiaCloudApi\Response\OperationResponse($response);

        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['deleteDomain'])
        ->getMock();

        $client->expects($this->once())
        ->method('deleteDomain')
        ->with('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 'deleted-domain.com')
        ->will($this->returnValue($message));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->deleteDomain('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 'deleted-domain.com');
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Removing the domain deleted-domain.com', $result->message);
    }
}
