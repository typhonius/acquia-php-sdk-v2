<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Account;

class AccountTest extends CloudApiTestCase
{
    public function testGetAccount(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Account/getAccount.json');
        $client = $this->getMockClient($response);

        $account = new Account($client);
        $account->get();
    }
}
