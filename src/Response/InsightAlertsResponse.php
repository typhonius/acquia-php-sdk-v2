<?php

namespace AcquiaCloudApi\Response;

/**
 * @template TValue
 * @template-extends \ArrayObject<int,TValue>
 */
class InsightAlertsResponse extends \ArrayObject
{

    /**
     * @param array<object> $alerts
     */
    public function __construct($alerts)
    {
        parent::__construct(
            array_map(
                function ($alert) {
                    return new InsightAlertResponse($alert);
                },
                $alerts
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
