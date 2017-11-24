<?php

use AcquiaCloudApi\CloudApi\Client;
use AcquiaCloudApi\CloudApi\Connector;
use GuzzleHttp\Client as GuzzleClient;

class ClientTest extends CloudApiTestCase
{

    public function testAddQuery()
    {
        $config = [
            'key' => 'd0697bfc-7f56-4942-9205-b5686bf5b3f5',
            'secret' => 'D5UfO/4FfNBWn4+0cUwpLOoFzfP7Qqib4AoY+wYGsKE=',
        ];
        $connector = new Connector($config);
        $client = Client::factory($connector);

        $client->addQuery('filter', 'name=dev');
        $client->addQuery('filter', 'type=file');

        $expectedQuery = [
            'filter' => [
                'name=dev',
                'type=file',
            ],
        ];

        $this->assertEquals($expectedQuery, $client->getQuery());
    }

    public function testFilteredQuery()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getFilteredCode.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $client->addQuery('filter', 'name=@*2014*');
        $client->addQuery('filter', 'type=@*true*');
        $result = $client->code('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        foreach ($result as $record) {
            $this->assertContains('2014', $record->name);
        }
    }

    public function testClearQuery()
    {
        $config = [
            'key' => 'd0697bfc-7f56-4942-9205-b5686bf5b3f5',
            'secret' => 'D5UfO/4FfNBWn4+0cUwpLOoFzfP7Qqib4AoY+wYGsKE=',
        ];
        $connector = new Connector($config);
        $client = Client::factory($connector);

        $client->addQuery('filter', 'name=dev');
        $this->assertEquals(['filter' => 'name=dev'], $client->getQuery());

        $client->clearQuery();
        $this->assertTrue(empty($client->getQuery()));
    }
}
