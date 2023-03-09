<?php

namespace AcquiaCloudApi\Response;

class LogForwardingDestinationResponse
{
    public string $uuid;

    public string $label;

    public string $address;

    public string $consumer;

    public object $credentials;

    /**
     * @var array<string> $sources
     */
    public array $sources;

    public string $status;

    public object $flags;

    public object $health;

    public object $environment;

    public function __construct(object $destination)
    {
        $this->uuid = $destination->uuid;
        $this->label = $destination->label;
        $this->address = $destination->address;
        $this->consumer = $destination->consumer;
        $this->credentials = $destination->credentials;
        $this->sources = $destination->sources;
        $this->status = $destination->status;
        $this->flags = $destination->flags;
        $this->health = $destination->health;
        $this->environment = $destination->environment;
    }
}
