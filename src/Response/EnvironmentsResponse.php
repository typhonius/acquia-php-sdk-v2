<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<EnvironmentResponse>
 */
class EnvironmentsResponse extends CollectionResponse
{

    /**
     * @param array<object> $environments
     */
    public function __construct($environments)
    {
        parent::__construct('EnvironmentResponse', $environments);
    }
}
