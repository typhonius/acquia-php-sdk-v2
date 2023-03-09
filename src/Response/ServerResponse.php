<?php

namespace AcquiaCloudApi\Response;

class ServerResponse
{
    public string $id;

    public string $name;

    public string $hostname;

    public string $ip;

    public string $status;

    public string $region;

    /**
     * @var array<string> $roles
     */
    public array $roles;

    public string $amiType;

    public object $configuration;

    public object $flags;

    public function __construct(object $server)
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
