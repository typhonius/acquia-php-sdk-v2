<?php

namespace AcquiaCloudApi\Response;

/**
 * Class InsightsResponse
 * @package AcquiaCloudApi\Response
 */
class InsightsResponse extends \ArrayObject
{

    /**
     * InsightsResponse constructor.
     * @param array $insights
     */
    public function __construct($insights)
    {
        parent::__construct(array_map(function ($insight) {
            return new InsightResponse($insight);
        }, $insights), self::ARRAY_AS_PROPS);
    }
}
