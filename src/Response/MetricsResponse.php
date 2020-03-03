<?php

namespace AcquiaCloudApi\Response;

/**
 * Class MetricsResponse
 *
 * @package AcquiaCloudApi\Response
 */
class MetricsResponse extends \ArrayObject
{

    /**
     * MetricsResponse constructor.
     *
     * @param array $metrics
     */
    public function __construct($metrics)
    {
        parent::__construct(
            array_map(
                function ($metric) {
                    return new MetricResponse($metric);
                },
                $metrics
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
