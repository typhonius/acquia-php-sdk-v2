<?php

class VarnishTest extends CloudApiTestCase
{

    public function testPurgeVarnish()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/purgeVarnish.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->purgeVarnishCache('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', ['example.com', 'www.example.com']);

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Varnish is being cleared for the selected domains.', $result->message);
    }
}
