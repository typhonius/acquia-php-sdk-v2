<?php

namespace AcquiaCloudApi\Response;

/**
 * Class DatabaseResponse
 * @package AcquiaCloudApi\Response
 */
class DatabaseResponse
{

    public $name;

    /**
     * DatabaseResponse constructor.
     * @param object $database
     */
    public function __construct($database)
    {
        $this->name = $database->name;
    }
}
