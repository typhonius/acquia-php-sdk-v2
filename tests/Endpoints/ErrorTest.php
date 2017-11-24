<?php

class ErrorTest extends CloudApiTestCase
{

    public function testError403()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/error403.json');

        $client = $this->getMockClient($response);

        try {
          /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
            $client->applications();
        } catch (Exception $e) {
            $this->assertEquals($e->getMessage(), 'You do not have permission to view applications.');

            return;
        }

        $this->fail();
    }

    public function testError404()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/error404.json');

        $client = $this->getMockClient($response);

        try {
          /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
            $client->applications();
        } catch (Exception $e) {
            $this->assertEquals($e->getMessage(), 'The application you are trying to access does not exist, or you do not have permission to access it.');

            return;
        }

        $this->fail();
    }
}
