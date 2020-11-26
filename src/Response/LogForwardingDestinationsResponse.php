<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<LogForwardingDestinationResponse>
 */
class LogForwardingDestinationsResponse extends CollectionResponse
{

    /**
     * @param array<object> $destinations
     */
    public function __construct($destinations)
    {
        parent::__construct('LogForwardingDestinationResponse', $destinations);
    }
}
