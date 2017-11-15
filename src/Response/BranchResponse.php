<?php

namespace AcquiaCloudApi\Response;

/**
 * Class BranchResponse
 * @package AcquiaCloudApi\Response
 */
class BranchResponse
{

    public $name;
    public $flags;

    /**
     * BranchResponse constructor.
     * @param object $branch
     */
    public function __construct($branch)
    {
        $this->name = $branch->name;
        $this->flags = $branch->flags;
    }
}
