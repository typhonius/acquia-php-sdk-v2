<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<CronResponse>
 */
class CronsResponse extends CollectionResponse
{

    /**
     * @param array<object> $crons
     */
    public function __construct($crons)
    {
        parent::__construct('CronResponse', $crons);
    }
}
