<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Environments;

class FilesTest extends CloudApiTestCase
{
    public function testFilesCopy(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Environments/copyFiles.json');
        $client = $this->getMockClient($response);

        $environment = new Environments($client);
        $result = $environment->copyFiles(
            '8ff6c046-ec64-4ce4-bea6-27845ec18600',
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851'
        );

        $requestOptions = [
            'json' => [
                'source' => '8ff6c046-ec64-4ce4-bea6-27845ec18600',
            ],
        ];

        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals('Copying files.', $result->message);
    }
}
