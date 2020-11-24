<?php

namespace AcquiaCloudApi\Response;

class LogForwardingDestinationResponse
{
    /**
     * @var string $uuid
     */
    public $uuid;

    /**
     * @var string $label
     */
    public $label;

    /**
     * @var string $address
     */
    public $address;

    /**
     * @var string $consumer
     */
    public $consumer;

    /**
     * @var object $credentials
     */
    public $credentials;

    /**
     * @var array<string> $sources
     */
    public $sources;

    /**
     * @var string $status
     */
    public $status;

    /**
     * @var object $flags
     */
    public $flags;

    /**
     * @var object $health
     */
    public $health;

    /**
     * @var object $environment
     */
    public $environment;

    /**
     * @param object $destination
     */
    public function __construct($destination)
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
