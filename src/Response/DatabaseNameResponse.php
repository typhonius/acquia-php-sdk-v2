<?php

namespace AcquiaCloudApi\Response;

class DatabaseNameResponse
{
    public string $name;
    public function __construct(object $database)
    {
        $this->name = $database->name;
    }
}
