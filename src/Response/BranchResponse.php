<?php

namespace AcquiaCloudApi\Response;

class BranchResponse
{
    public string $name;

    public object $flags;

    /**
     */
    public function __construct(object $branch)
    {
        $this->name = $branch->name;
        $this->flags = $branch->flags;
    }
}
