<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\InsightResponse>
 */
class InsightsResponse extends \ArrayObject
{
    /**
     * @param array<object> $insights
     */
    public function __construct(array $insights)
    {
        parent::__construct(
            array_map(
                static function ($insight) {
                    return new InsightResponse($insight);
                },
                $insights
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
