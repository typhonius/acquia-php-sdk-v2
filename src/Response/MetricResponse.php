<?php

namespace AcquiaCloudApi\Response;

/**
 * Class MetricResponse
 *
 * @package AcquiaCloudApi\Response
 */
class MetricResponse
{
    public $metric;
    public $datapoints;
    public $last_data_at;
    public $metadata;
    public $links;

    /**
     * MetricResponse constructor.
     *
     * @param object $metric
     */
    public function __construct($metric)
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
