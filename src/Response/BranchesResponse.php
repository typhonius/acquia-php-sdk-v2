<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\BranchResponse>
 */
class BranchesResponse extends \ArrayObject
{
    /**
     * @param array<object> $branches
     */
    public function __construct($branches)
    {
        parent::__construct(
            array_map(
                function ($branch) {
                    return new BranchResponse($branch);
                },
                $branches
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
