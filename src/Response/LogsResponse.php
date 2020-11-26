<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<LogResponse>
 */
class LogsResponse extends CollectionResponse
{

    /**
     * @param array<object> $logs
     */
    public function __construct($logs)
    {
        parent::__construct('LogResponse', $logs);
    }
}
