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
    'flags',
    'configuration',
    'links'
    ];

    public function testGetEnvironments()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getEnvironments.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
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
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getEnvironment.json');

        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->environment('24-a47ac10b-58cc-4372-a567-0e02b2c3d470');

        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\EnvironmentsResponse', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\EnvironmentResponse', $result);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testRenameEnvironment()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/renameEnvironment.json');

        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->renameEnvironment('24-a47ac10b-58cc-4372-a567-0e02b2c3d470', 'Alpha');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Changing environment label.', $result->message);
    }
}
