<?php

namespace AcquiaCloudApi\Response;

/**
 * @template TValue
 * @template-extends \ArrayObject<int,TValue>
 */
class InsightsResponse extends \ArrayObject
{

    /**
     * @param array<object> $insights
     */
    public function __construct($insights)
    {
        parent::__construct(
            array_map(
                function ($insight) {
                    return new InsightResponse($insight);
                },
                $insights
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
