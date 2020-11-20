<?php

namespace AcquiaCloudApi\Response;

/**
 * @template TValue
 * @template-extends \ArrayObject<int,TValue>
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
