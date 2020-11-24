<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Ides;

class IdesTest extends CloudApiTestCase
{
    /**
     * @var mixed[] $properties
     */
    public $properties = [
        'uuid',
        'label',
        'links',
        'owner',
    ];

    public function testGetAllIdes(): void
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Ides/getAllIdes.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $ide = new Ides($client);
        $result = $ide->getAll('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\IdesResponse', $result);
        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\IdeResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetIde(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Ides/getIde.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $ide = new Ides($client);
        $result = $ide->get('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\IdesResponse', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\IdeResponse', $result);

        foreach ($this->properties as $property) {
              $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testCreateIde(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Ides/createIde.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $ide = new Ides($client);
        $result = $ide->create(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            'My new IDE'
        );

        $requestOptions = [
            'json' => [
                'label' => 'My new IDE',
            ],
        ];

        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('The remote IDE is being created.', $result->message);
    }

    public function testDeleteIde(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Ides/deleteIde.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $ide = new Ides($client);
        $result = $ide->delete('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('The remote IDE is being deleted.', $result->message);
    }
}
