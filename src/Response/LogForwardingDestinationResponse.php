<?php

namespace AcquiaCloudApi\Response;

/**
 * Class LogForwardingDestinationResponse
 *
 * @package AcquiaCloudApi\Response
 */
class LogForwardingDestinationResponse
{

    public $uuid;
    public $label;
    public $address;
    public $consumer;
    public $credentials;
    public $sources;
    public $status;
    public $flags;
    public $health;
    public $environment;

    /**
     * LogForwardingDestinationResponse constructor.
     *
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
