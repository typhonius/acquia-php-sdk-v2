<?php

namespace AcquiaCloudApi\Response;

class ServerResponse
{
    /**
     * @var string $id
     */
    public $id;

    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $hostname
     */
    public $hostname;

    /**
     * @var string $ip
     */
    public $ip;

    /**
     * @var string $status
     */
    public $status;

    /**
     * @var string $region
     */
    public $region;

    /**
     * @var array<string> $roles
     */
    public $roles;

    /**
     * @var string $amiType
     */
    public $amiType;

    /**
     * @var object $configuration
     */
    public $configuration;

    /**
     * @var object $flags
     */
    public $flags;

    /**
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
