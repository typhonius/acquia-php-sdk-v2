<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\LogResponse>
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
