<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;

/**
 * Class CloudApiBase
 *
 * @package AcquiaCloudApi\CloudApi
 */
abstract class CloudApiBase implements CloudApiInterface
{

    /**
     * @var ClientInterface The API client.
     */
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
}
