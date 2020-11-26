<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<InsightAlertResponse>
 */
class InsightAlertsResponse extends CollectionResponse
{

    /**
     * @param array<object> $alerts
     */
    public function __construct($alerts)
    {
        parent::__construct('InsightAlertResponse', $alerts);
    }
}
