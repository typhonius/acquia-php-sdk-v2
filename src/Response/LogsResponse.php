<?php

namespace AcquiaCloudApi\Response;

/**
 * Class LogsResponse
 *
 * @package AcquiaCloudApi\Response
 */
class LogsResponse extends \ArrayObject
{

    /**
     * LogsResponse constructor.
     *
     * @param array $logs
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
