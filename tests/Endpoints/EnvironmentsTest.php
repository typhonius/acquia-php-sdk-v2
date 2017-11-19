<?php

class EnvironmentsTest extends CloudApiTestCase
{

    public $properties = [
    'uuid',
    'label',
    'name',
    'domains',
    'sshUrl',
    'ips',
    'region',
    'status',
    'type',
    'vcs',
    'insight',
    'flags',
    'configuration',
    'links'
    ];

    public function testGetEnvironments()
    {

        $response = $this->generateCloudApiResponse('Endpoints/getEnvironments.json');
        $envirionments = new \AcquiaCloudApi\Response\EnvironmentsResponse($response);


        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['environments'])
        ->getMock();
        $client->expects($this->once())
        ->method('environments')
        ->with('8ff6c046-ec64-4ce4-bea6-27845ec18600')
        ->will($this->returnValue($envirionments));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->environments('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\EnvironmentsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\EnvironmentResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetEnvironment()
    {
        $response = $this->generateCloudApiResponse('Endpoints/getEnvironment.json');

        $environment = new \AcquiaCloudApi\Response\EnvironmentResponse($response);

        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['environment'])
        ->getMock();

        $client->expects($this->once())
        ->method('environment')
        ->with('24-a47ac10b-58cc-4372-a567-0e02b2c3d470')
        ->will($this->returnValue($environment));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->environment('24-a47ac10b-58cc-4372-a567-0e02b2c3d470');

        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\EnvironmentsResponse', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\EnvironmentResponse', $result);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }
}
