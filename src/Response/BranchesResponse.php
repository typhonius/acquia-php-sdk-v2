<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<BranchResponse>
 */
class BranchesResponse extends CollectionResponse
{

    /**
     * @param array<object> $branches
     */
    public function __construct($branches)
    {
        parent::__construct('BranchResponse', $branches);
    }
}
