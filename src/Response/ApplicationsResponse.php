<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<ApplicationResponse>
 */
class ApplicationsResponse extends CollectionResponse
{

    /**
     * @param array<object> $applications
     */
    public function __construct($applications)
    {
        parent::__construct('ApplicationResponse', $applications);
    }
}
