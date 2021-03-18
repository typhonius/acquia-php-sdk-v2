<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\SshKeys;

class SshKeysTest extends CloudApiTestCase
{
    /**
     * @var mixed[] $properties
     */
    public $properties = [
        'uuid',
        'label',
        'public_key'
    ];

    public function testGetKeys(): void
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SshKeys/getAllSshKeys.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $key = new SshKeys($client);
        $result = $key->getAll();

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\SshKeysResponse', $result);
        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\SshKeyResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetKey(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SshKeys/getSshKey.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $key = new SshKeys($client);
        $result = $key->get('1bc40e0d-da9f-4915-a264-624a03edcbd8');

        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\SshKeysResponse', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\SshKeyResponse', $result);

        foreach ($this->properties as $property) {
              $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testCreateSshKey(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SshKeys/createSshKey.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $key = new SshKeys($client);
        $result = $key->create(
            'Test SSH Key 3',
            'sha-rsa...= Test Key 3'
        );

        $requestOptions = [
            'json' => [
                'label' => 'Test SSH Key 3',
                'public_key' => 'sha-rsa...= Test Key 3'
            ],
        ];
        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Adding SSH key.', $result->message);
    }

    public function testDeleteSshKey(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SshKeys/deleteSshKey.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $key = new SshKeys($client);
        $result = $key->delete('1bc40e0d-da9f-4915-a264-624a03edcbd8');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Removed SSH key.', $result->message);
    }
}
