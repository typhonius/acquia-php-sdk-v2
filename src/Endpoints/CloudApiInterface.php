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
     */
    public function __construct(ClientInterface $client);
}
