<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Environments;

class LiveDevTest extends CloudApiTestCase
{
    public function testLiveDevEnable(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Environments/enableLiveDev.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $environment = new Environments($client);
        $result = $environment->enableLiveDev('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Live Dev is being enabled.', $result->message);
    }

    public function testLiveDevDisable(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Environments/disableLiveDev.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $environment = new Environments($client);
        $result = $environment->disableLiveDev('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $requestOptions = [
            'json' => [
                'discard' => 1,
            ],
        ];

        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Live Dev is being disabled.', $result->message);
    }
}
