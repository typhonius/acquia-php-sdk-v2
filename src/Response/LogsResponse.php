<?php

namespace AcquiaCloudApi\Response;

/**
 * @template TValue
 * @template-extends \ArrayObject<int,TValue>
 */
class LogsResponse extends \ArrayObject
{

    /**
     * @param array<object> $logs
     */
    public function __construct($logs)
    {
        parent::__construct(
            array_map(
                function ($log) {
                    return new LogResponse($log);
                },
                $logs
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
