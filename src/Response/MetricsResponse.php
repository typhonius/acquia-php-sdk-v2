<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<MetricResponse>
 */
class MetricsResponse extends CollectionResponse
{

    /**
     * @param array<object> $metrics
     */
    public function __construct($metrics)
    {
        parent::__construct('MetricResponse', $metrics);
    }
}
