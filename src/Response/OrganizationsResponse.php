<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<OrganizationResponse>
 */
class OrganizationsResponse extends CollectionResponse
{

    /**
     * @param array<object> $organizations
     */
    public function __construct($organizations)
    {
        parent::__construct('OrganizationResponse', $organizations);
    }
}
