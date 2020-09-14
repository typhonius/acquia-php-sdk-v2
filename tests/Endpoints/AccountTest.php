<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Account;

class AccountTest extends CloudApiTestCase
{

    protected $properties = [
    'id',
    'uuid',
    'name',
    'first_name',
    'last_name',
    'last_login_at',
    'created_at',
    'mail',
    'phone',
    'job_title',
    'job_function',
    'company',
    'country',
    'state',
    'timezone',
    'picture_url',
    'features',
    'flags',
    'metadata',
    'links'
    ];

    public function testGetAccount()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Account/getAccount.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $account = new Account($client);
        $result = $account->get();

        $this->assertInstanceOf('\AcquiaCloudApi\Response\AccountResponse', $result);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }
}
