<?php

namespace AcquiaCloudApi\Response;

/**
 * @template TValue
 * @template-extends \ArrayObject<int,TValue>
 */
class ServersResponse extends \ArrayObject
{

    /**
     * @param array<object> $servers
     */
    public function __construct($servers)
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
