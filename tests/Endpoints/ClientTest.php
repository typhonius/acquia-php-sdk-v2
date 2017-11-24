<?php

use AcquiaCloudApi\CloudApi\Client;
use AcquiaCloudApi\CloudApi\Connector;
use GuzzleHttp\Client as GuzzleClient;

class ClientTest extends CloudApiTestCase
{

    protected $properties = [
        'uuid',
        'name',
        'hosting',
        'subscription',
        'organization',
        'type',
        'flags',
        'status',
        'links'
    ];

    public function testClearQuery()
    {
        $config = [
            'key' => 'd0697bfc-7f56-4942-9205-b5686bf5b3f5',
            'secret' => 'D5UfO/4FfNBWn4+0cUwpLOoFzfP7Qqib4AoY+wYGsKE=',
        ];
        $connector = new Connector(new GuzzleClient, $config);
        $client = Client::factory($connector);
        $this->assertTrue(empty($client->getQuery()));
    }
}
