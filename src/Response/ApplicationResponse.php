<?php

namespace AcquiaCloudApi\Response;

/**
 * Class ApplicationResponse
 * @package AcquiaCloudApi\Response
 */
class ApplicationResponse
{

    public $id;
    public $uuid;
    public $name;
    public $hosting;
    public $subscription;
    public $organization;
    public $type;
    public $flags;
    public $status;
    public $links;

    /**
     * ApplicationResponse constructor.
     * @param object $application
     */
    public function __construct($application)
    {
        $this->id = $application->id;
        $this->uuid = $application->uuid;
        $this->name = $application->name;
        $this->hosting = $application->hosting;
        $this->subscription = $application->subscription;
        $this->organization = $application->organization;
        if (property_exists($application, 'type')) {
            $this->type = $application->type;
        }
        $this->flags = $application->flags;
        $this->status = $application->status;
        $this->links = $application->_links;
    }
}
