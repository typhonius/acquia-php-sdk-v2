<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Environments;

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

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Environments/getAllEnvironments.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $environments = new Environments($client);
        $result = $environments->getAll('8ff6c046-ec64-4ce4-bea6-27845ec18600');

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
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Environments/getEnvironment.json');

        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $environment = new Environments($client);
        $result = $environment->get('24-a47ac10b-58cc-4372-a567-0e02b2c3d470');

        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\EnvironmentsResponse', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\EnvironmentResponse', $result);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testModifyEnvironment()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Environments/updateEnvironment.json');

        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $environment = new Environments($client);
        $result = $environment->update('24-a47ac10b-58cc-4372-a567-0e02b2c3d470', ['version' => '7.2']);

         $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

         $this->assertEquals('The environment configuration is being updated.', $result->message);
    }

    public function testRenameEnvironment()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Environments/renameEnvironment.json');

        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $environment = new Environments($client);
        $result = $environment->rename('24-a47ac10b-58cc-4372-a567-0e02b2c3d470', 'Alpha');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Changing environment label.', $result->message);
    }

    public function testCreateCDEnvironment()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Environments/createCDEnvironment.json');

        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $environment = new Environments($client);
        $result = $environment->create(
            '24-a47ac10b-58cc-4372-a567-0e02b2c3d470',
            'CD label',
            'my-feature-branch',
            [
                "database1",
                "database2"
            ]
        );

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Adding an environment.', $result->message);
    }

    public function testDeleteCDEnvironment()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Environments/deleteCDEnvironment.json');

        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $environment = new Environments($client);
        $result = $environment->delete('24-a47ac10b-58cc-4372-a567-0e02b2c3d470');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('The environment is being deleted.', $result->message);
    }
}
