<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Environments;

class FilesTest extends CloudApiTestCase
{

    public function testFilesCopy()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Environments/copyFiles.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $environment = new Environments($client);
        $result = $environment->copyFiles(
            '8ff6c046-ec64-4ce4-bea6-27845ec18600',
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851'
        );
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Copying files.', $result->message);
    }
}
