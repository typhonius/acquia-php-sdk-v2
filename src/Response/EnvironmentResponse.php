<?php

namespace AcquiaCloudApi\Response;

class EnvironmentResponse
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
     * @var string $name
     */
    public $name;

    /**
     * @var array<string> $domains
     */
    public $domains;

    /**
     * @var string|null $sshUrl
     */
    public $sshUrl;

    /**
     * @var array<string> $ips
     */
    public $ips;

    /**
     * @var string $region
     */
    public $region;

    /**
     * @var string $status
     */
    public $status;

    /**
     * @var string $type
     */
    public $type;

    /**
     * @var object $vcs
     */
    public $vcs;

    /**
     * @var object $flags
     */
    public $flags;

    /**
     * @var object $configuration
     */
    public $configuration;

    /**
     * @var object $links
     */
    public $links;
    
    /**
     * @var string $platform
     */
    public $platform;

    /**
     * @param object $environment
     */
    public function __construct($environment)
    {
        $this->uuid = $environment->id;
        $this->label = $environment->label;
        $this->name = $environment->name;
        $this->domains = $environment->domains;
        if (property_exists($environment, 'ssh_url')) {
            $this->sshUrl = $environment->ssh_url;
        }
        $this->ips = $environment->ips;
        $this->region = $environment->region;
        $this->status = $environment->status;
        $this->type = $environment->type;
        $this->vcs = $environment->vcs;
        $this->configuration = $environment->configuration;
        $this->flags = $environment->flags;
        $this->links = $environment->_links;
        $this->platform = $environment->platform;
    }
}
