<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\InsightAlertResponse>
 */
class InsightAlertsResponse extends \ArrayObject
{
    /**
     * @param array<object> $alerts
     */
    public function __construct(array $alerts)
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
