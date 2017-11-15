<?php

namespace AcquiaCloudApi\Response;

/**
 * Class ServersResponse
 * @package AcquiaCloudApi\Response
 */
class ServersResponse extends \ArrayObject
{

    /**
     * ApplicationsResponse constructor.
     * @param array $servers
     */
    public function __construct($servers)
    {
        parent::__construct(array_map(function ($server) {
            return new ServerResponse($server);
        }, $servers), self::ARRAY_AS_PROPS);
    }
}
