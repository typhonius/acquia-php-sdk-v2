<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;
use AcquiaCloudApi\Response\AccountResponse;
use Psr\Http\Message\StreamInterface;

/**
 * Class Client
 * @package AcquiaCloudApi\CloudApi
 */
class Account implements CloudApi
{

    /** @var ClientInterface The API client. */
    protected $client;

    /**
     * Client constructor.
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Returns details about your account.
     *
     * @return AccountResponse
     */
    public function getAccount()
    {
        return new AccountResponse($this->client->request('get', '/account'));
    }

    /**
     * Provides an archived set of files for Acquia Drush aliases.
     *
     * @return object
     */
    public function getDrushAliases()
    {
        return $this->client->request('get', '/account/drush-aliases/download');
    }
}
