<?php

namespace AcquiaCloudApi\Response;

class MetricResponse
{
    public string $metric;

    /**
     * @var array<array<mixed>> $datapoints
     */
    public array $datapoints;

    public ?string $last_data_at;

    public object $metadata;

    public ?object $links;

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
