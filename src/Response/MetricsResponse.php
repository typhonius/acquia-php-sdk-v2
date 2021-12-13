<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\MetricResponse>
 */
class MetricsResponse extends \ArrayObject
{
    /**
     * @param array<object> $metrics
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
