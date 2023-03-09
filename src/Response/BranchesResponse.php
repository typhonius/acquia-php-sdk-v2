<?php

namespace AcquiaCloudApi\Response;

use ArrayObject;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\BranchResponse>
 */
class BranchesResponse extends ArrayObject
{
    /**
     * @param array<object> $branches
     */
    public function __construct(array $branches)
    {
        parent::__construct(
            array_map(
                static function ($branch) {
                    return new BranchResponse($branch);
                },
                $branches
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
