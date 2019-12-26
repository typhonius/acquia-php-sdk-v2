<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;

/**
 * The CloudApi Interface.
 */
interface CloudApiInterface
{
    /**
     * CloudApiInterface constructor.
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client);
}
