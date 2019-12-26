<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;

interface CloudApiInterface
{
    public function __construct(ClientInterface $client);
}
