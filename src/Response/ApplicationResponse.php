<?php

namespace AcquiaCloudApi\Response;

class ApplicationResponse
{
    /**
     * @var int $id
     */
    public $id;

    /**
     * @var string $uuid
     */
    public $uuid;

    /**
     * @var string $name
     */
    public $name;

    /**
     * @var object $hosting
     */
    public $hosting;

    /**
     * @var object $subscription
     */
    public $subscription;

    /**
     * @var object $organization
     */
    public $organization;

    /**
     * @var string|null $type
     */
    public $type;

    /**
     * @var object $flags
     */
    public $flags;

    /**
     * @var string $status
     */
    public $status;

    /**
     * @var object $links
     */
    public $links;

    /**
     * @param object $application
     */
    public function __construct(object $application)
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
