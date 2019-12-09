<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Environments;

class ProductionModeTest extends CloudApiTestCase
{

    public function testProductionModeEnable()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Environments/enableProductionMode.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $environment = new Environments($client);
        $result = $environment->enableProductionMode('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Production mode has been enabled for this environment.', $result->message);
    }

    public function testProductionModeDisable()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Environments/disableProductionMode.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $environment = new Environments($client);
        $result = $environment->disableProductionMode('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Production mode has been disabled for this environment.', $result->message);
    }
}
