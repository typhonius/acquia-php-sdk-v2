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
        $connector = new Connector(new GuzzleClient);
        $client = Client::factory(
            [
                'key' => 'd0697bfc-7f56-4942-9205-b5686bf5b3f5',
                'secret' => 'D5UfO/4FfNBWn4+0cUwpLOoFzfP7Qqib4AoY+wYGsKE=',
            ],
            $connector
            );
        $this->assertTrue(empty($client->getQuery()));
    }

    public function testApplications()
    {
    }
}
