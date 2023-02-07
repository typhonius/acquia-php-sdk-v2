<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Account;

class AccountTest extends CloudApiTestCase
{
    /**
     * @var array<string> $properties
     */
    protected array $properties = [
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

    public function testGetAccount(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Account/getAccount.json');
        $client = $this->getMockClient($response);

        $account = new Account($client);
        $account->get();
    }
}
