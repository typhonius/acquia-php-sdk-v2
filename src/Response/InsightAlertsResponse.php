<?php

namespace AcquiaCloudApi\Response;

/**
 * Class InsightAlertsResponse
 *
 * @package AcquiaCloudApi\Response
 */
class InsightAlertsResponse extends \ArrayObject
{

    /**
     * InsightAlertsResponse constructor.
     *
     * @param array $alerts
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
