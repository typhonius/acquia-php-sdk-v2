<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\ServerResponse>
 */
class ServersResponse extends \ArrayObject
{
    /**
     * @param array<object> $servers
     */
    public function __construct(array $servers)
    {
        parent::__construct(
            array_map(
                function ($server) {
                    return new ServerResponse($server);
                },
                $servers
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
