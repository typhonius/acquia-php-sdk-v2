<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;

interface CloudApi
{
    public function __construct(ClientInterface $client);
}
