<?php

use AcquiaCloudApi\CloudApi\Client;

class AccountTest extends CloudApiTestCase
{

    protected $properties = [
    'id',
    'uuid',
    'name',
    'last_login_at',
    'created_at',
    'mail',
    'features',
    'flags',
    'metadata',
    'links'
    ];

    public function testGetAccount()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getAccount.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $result = $client->account();

        $this->assertInstanceOf('\AcquiaCloudApi\Response\AccountResponse', $result);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }
}
