<?php

namespace AcquiaCloudApi\Response;

/**
 * Class ApplicationResponse
 * @package AcquiaCloudApi\Response
 */
class ApplicationResponse
{

    public $uuid;
    public $name;
    public $hosting;

    /**
     * ApplicationResponse constructor.
     * @param object $application
     */
    public function __construct($application)
    {
        $this->uuid = $application->uuid;
        $this->name = $application->name;
        $this->hosting = $application->hosting;
    }
}