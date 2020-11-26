<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<InsightResponse>
 */
class InsightsResponse extends CollectionResponse
{

    /**
     * @param array<object> $insights
     */
    public function __construct($insights)
    {
        parent::__construct('InsightResponse', $insights);
    }
}
