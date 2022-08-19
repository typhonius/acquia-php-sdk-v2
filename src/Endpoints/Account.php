<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\AccountResponse;
use Psr\Http\Message\StreamInterface;

/**
 * Class Account
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Account extends CloudApiBase
{
    /**
     * Returns details about your account.
     *
     * @return AccountResponse
     */
    public function get(): AccountResponse
    {
        return new AccountResponse($this->client->request('get', '/account'));
    }

    /**
     * Provides an archived set of files for Acquia Drush aliases.
     *
     * @return StreamInterface
     */
    public function getDrushAliases(): StreamInterface
    {
        return $this->client->stream('get', '/account/drush-aliases/download');
    }
}
