<?php

namespace AcquiaCloudApi\Response;

class EnvironmentResponse
{
    public string $uuid;

    public string $label;

    public string $name;

    public object $application;

    /**
     * @var array<string> $domains
     */
    public array $domains;

    public string $active_domain;

    public string $default_domain;

    public ?string $image_url;

    public ?string $sshUrl;

    /**
     * @var array<string> $ips
     */
    public array $ips;

    public string $region;

    public string $status;

    public string $type;

    public object $vcs;

    public object $flags;

    public ?object $configuration;

    public object $links;

    public string $platform;

    public string $balancer;

    public ?object $artifact;

    /**
     */
    public function __construct(object $environment)
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
