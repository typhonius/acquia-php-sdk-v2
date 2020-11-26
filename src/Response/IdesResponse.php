<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<IdeResponse>
 */
class IdesResponse extends CollectionResponse
{

    /**
     * @param array<object> $ides
     */
    public function __construct($ides)
    {
        parent::__construct('IdeResponse', $ides);
    }
}
