<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Environments;

class EnvironmentsTest extends CloudApiTestCase
{
    /**
     * @var mixed[] $properties
     */
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
        'links',
        'platform',
        'balancer',
    ];

    public function testGetEnvironments(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Environments/getAllEnvironments.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $environments = new Environments($client);
        $result = $environments->getAll('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\EnvironmentsResponse', $result);
        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\EnvironmentResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetEnvironment(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Environments/getEnvironment.json');

        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $environment = new Environments($client);
        $result = $environment->get('24-a47ac10b-58cc-4372-a567-0e02b2c3d470');

        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\EnvironmentsResponse', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\EnvironmentResponse', $result);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testModifyEnvironment(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Environments/updateEnvironment.json');

        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $environment = new Environments($client);
        $result = $environment->update('24-a47ac10b-58cc-4372-a567-0e02b2c3d470', ['version' => '7.2']);

        $requestOptions = [
            'json' => [
                'version' => '7.2',
            ],
        ];

        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('The environment configuration is being updated.', $result->message);
    }

    public function testRenameEnvironment(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Environments/renameEnvironment.json');

        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $environment = new Environments($client);
        $result = $environment->rename('24-a47ac10b-58cc-4372-a567-0e02b2c3d470', 'Alpha');

        $requestOptions = [
            'json' => [
                'label' => 'Alpha',
            ],
        ];

        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Changing environment label.', $result->message);
    }

    public function testCreateCDEnvironment(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Environments/createCDEnvironment.json');

        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
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

        $requestOptions = [
            'json' => [
                'label' => 'CD label',
                'branch' => 'my-feature-branch',
                'databases' => [
                    "database1",
                    "database2"
                ],
            ],
        ];

        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Adding an environment.', $result->message);
    }

    public function testDeleteCDEnvironment(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Environments/deleteCDEnvironment.json');

        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $environment = new Environments($client);
        $result = $environment->delete('24-a47ac10b-58cc-4372-a567-0e02b2c3d470');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('The environment is being deleted.', $result->message);
    }

    public function testEnableEmail(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Environments/enableEmail.json');

        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $environment = new Environments($client);
        $result = $environment->enableEmail('24-a47ac10b-58cc-4372-a567-0e02b2c3d470');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Platform Email is being enabled', $result->message);
    }

    public testDisableEmail(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Environments/enableEmail.json');

        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $environment = new Environments($client);
        $result = $environment->disableEmail('24-a47ac10b-58cc-4372-a567-0e02b2c3d470');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Platform Email is being disabled', $result->message);
    }
}
