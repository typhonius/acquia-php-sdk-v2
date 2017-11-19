<?php

namespace AcquiaCloudApi\Response;

/**
 * Class EnvironmentResponse
 * @package AcquiaCloudApi\Response
 */
class EnvironmentResponse
{
    public $uuid;
    public $label;
    public $name;
    public $domains;
    public $sshUrl;
    public $ips;
    public $region;
    public $status;
    public $type;
    public $vcs;
    public $insight;
    public $flags;
    public $configuration;
    public $links;

    /**
     * EnvironmentResponse constructor.
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
        $this->insight = $environment->insight;
        $this->flags = $environment->configuration;
        $this->links = $environment->_links;
    }
}
