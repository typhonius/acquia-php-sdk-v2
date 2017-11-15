<?php

namespace AcquiaCloudApi\Response;

/**
 * Class BranchesResponse
 * @package AcquiaCloudApi\Response
 */
class BranchesResponse extends \ArrayObject
{

    /**
     * ApplicationsResponse constructor.
     * @param array $branches
     */
    public function __construct($branches)
    {
        parent::__construct(array_map(function ($branch) {
            return new BranchResponse($branch);
        }, $branches), self::ARRAY_AS_PROPS);
    }
}
