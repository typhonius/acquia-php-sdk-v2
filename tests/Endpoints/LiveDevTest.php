<?php

class LiveDevTest extends CloudApiTestCase
{

    public function testLiveDevEnable()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/enableLiveDev.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->enableLiveDev('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Live Dev is being enabled.', $result->message);
    }

    public function testLiveDevDisable()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/disableLiveDev.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->disableLiveDev('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Live Dev is being disabled.', $result->message);
    }
}
