<?php

use AcquiaCloudApi\CloudApi\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();

    }

    public function testClearQuery()
    {
        $client = new Client();

        $client->clearQuery();
        $this->assertTrue(empty($client->getQuery()));
    }

}
