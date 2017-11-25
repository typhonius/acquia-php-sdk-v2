<?php

namespace AcquiaCloudApi\Response;

/**
 * Class ServerResponse
 * @package AcquiaCloudApi\Response
 */
class ServerResponse
{

    public $id;
    public $name;
    public $hostname;
    public $ip;
    public $status;
    public $region;
    public $roles;
    public $amiType;
    public $configuration;
    public $flags;

    /**
     * ServerResponse constructor.
     * @param object $server
     */
    public function __construct($server)
    {
        $this->id = $server->id;
        $this->name = $server->name;
        $this->hostname = $server->hostname;
        $this->ip = $server->ip;
        $this->status = $server->status;
        $this->region = $server->region;
        $this->roles = $server->roles;
        $this->amiType = $server->ami_type;
        $this->configuration = $server->configuration;
        $this->flags = $server->flags;
    }
}
