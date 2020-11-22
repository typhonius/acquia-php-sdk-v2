<?php

namespace AcquiaCloudApi\Response;

class DatabaseResponse extends GenericResponse
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
