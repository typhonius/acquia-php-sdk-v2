<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<DomainResponse>
 */
class DomainsResponse extends CollectionResponse
{

    /**
     * @param array<object> $domains
     */
    public function __construct($domains)
    {
        parent::__construct('DomainResponse', $domains);
    }
}
