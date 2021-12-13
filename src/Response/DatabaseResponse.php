<?php

namespace AcquiaCloudApi\Response;

class DatabaseResponse
{
    /**
     * @var string $name
     */
    public $name;

    /**
     * @param object $database
     */
    public function __construct($database)
    {
        $this->name = $database->name;
    }
}
