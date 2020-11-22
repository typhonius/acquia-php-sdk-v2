<?php

namespace AcquiaCloudApi\Response;

class BranchResponse extends GenericResponse
{
    /**
     * @var string $name
     */
    public $name;

    /**
     * @var object $flags
     */
    public $flags;

    /**
     * @param object $branch
     */
    public function __construct($branch)
    {
        $this->name = $branch->name;
        $this->flags = $branch->flags;
    }
}
