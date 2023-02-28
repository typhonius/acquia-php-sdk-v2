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
     * @var object $application
     */
    public $application;

    /**
     * @var array<string> $domains
     */
    public $domains;

    /**
     * @var string $active_domain
     */
    public $active_domain;

    /**
     * @var string $default_domain
     */
    public $default_domain;

    /**
     * @var string $image_url
     */
    public $image_url;

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
     * @var string $balancer
     */
    public $balancer;

    /**
     * @var object $artifact
     */
    public $artifact;

    /**
     * @param object $environment
     */
    public function __construct($environment)
    {
        $this->uuid = $environment->id;
        $this->label = $environment->label;
        $this->name = $environment->name;
        $this->application = $environment->application;
        $this->domains = $environment->domains;
        $this->active_domain = $environment->active_domain;
        $this->default_domain = $environment->default_domain;
        $this->image_url = $environment->image_url;
        if (property_exists($environment, 'ssh_url')) {
            $this->sshUrl = $environment->ssh_url;
        }
        $this->ips = $environment->ips;
        $this->region = $environment->region;
        $this->balancer = $environment->balancer;
        $this->platform = $environment->platform;
        $this->status = $environment->status;
        $this->type = $environment->type;
        $this->vcs = $environment->vcs;
        $this->configuration = $environment->configuration;
        $this->flags = $environment->flags;
        $this->artifact = $environment->artifact;
        $this->links = $environment->_links;
    }
}
