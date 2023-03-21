<?php

namespace AcquiaCloudApi\Response;

class ApplicationResponse
{
    public int $id;

    public string $uuid;

    public string $name;

    public ?object $hosting;

    public object $subscription;

    public object $organization;

    public ?string $type;

    public object $flags;

    public string $status;

    public object $links;

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
