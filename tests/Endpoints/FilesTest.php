<?php

class FilesTest extends CloudApiTestCase
{

    public function testFilesCopy()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/copyFiles.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->copyFiles('8ff6c046-ec64-4ce4-bea6-27845ec18600', '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('The files have been queued for copying.', $result->message);
    }
}
