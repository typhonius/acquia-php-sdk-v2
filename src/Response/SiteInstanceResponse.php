<?php

namespace AcquiaCloudApi\Response;

class SiteInstanceResponse
{
    public string $siteId;

    public string $environmentId;

    public string $status;

    public ?string $name;

    public ?string $label;

    public ?object $database;

    /**
     * @var array<object>|null $domains
     */
    public ?array $domains;

    public object $links;

    public function __construct(object $siteInstance)
    {
        $this->siteId = $siteInstance->site_id;
        $this->environmentId = $siteInstance->environment_id;
        $this->status = $siteInstance->status;
        $this->name = $siteInstance->name ?? null;
        $this->label = $siteInstance->label ?? null;
        $this->database = $siteInstance->database ?? null;
        $this->domains = $siteInstance->domains ?? null;
        $this->links = $siteInstance->_links;
    }
}
