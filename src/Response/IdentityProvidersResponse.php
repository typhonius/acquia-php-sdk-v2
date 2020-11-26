<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<IdentityProviderResponse>
 */
class IdentityProvidersResponse extends CollectionResponse
{

    /**
     * @param array<object> $idps
     */
    public function __construct($idps)
    {
        parent::__construct('IdentityProviderResponse', $idps);
    }
}
