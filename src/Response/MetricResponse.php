<?php

namespace AcquiaCloudApi\Response;

class MetricResponse
{
    /**
     * @var string $metric
     */
    public $metric;

    /**
     * @var array<array<mixed>> $datapoints
     */
    public $datapoints;

    /**
     * @var string|null $last_data_at
     */
    public $last_data_at;

    /**
     * @var object $metadata
     */
    public $metadata;

    /**
     * @var object|null $links
     */
    public $links;

    /**
     * @param object $metric
     */
    public function __construct(object $metric)
    {
        $this->metric = $metric->metric;
        $this->datapoints = $metric->datapoints;
        if (property_exists($metric, 'last_data_at')) {
            $this->last_data_at = $metric->last_data_at;
        }
        $this->metadata = $metric->metadata;
        if (property_exists($metric, '_links')) {
            $this->links = $metric->_links;
        }
    }
}
