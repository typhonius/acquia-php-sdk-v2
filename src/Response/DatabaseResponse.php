<?php

namespace AcquiaCloudApi\Response;

class DatabaseResponse
{
    public string $name;

    public function __construct(object $database)
    {
        $this->name = $database->name;
    }
}
