<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<ServerResponse>
 */
class ServersResponse extends CollectionResponse
{

    /**
     * @param array<object> $servers
     */
    public function __construct($servers)
    {
        parent::__construct('ServerResponse', $servers);
    }
}
