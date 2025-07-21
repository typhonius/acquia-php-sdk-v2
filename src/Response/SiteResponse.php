<?php

namespace AcquiaCloudApi\Response;

class SiteResponse
{
    public string $id;

    public string $name;

    public string $label;

    public ?string $description;

    public ?string $codebaseId;

    public object $links;

    /**
     * SiteResponse constructor.
     *
     * @param object $site
     */
    public function __construct(object $site)
    {
        $this->id = $site->id;
        $this->name = $site->name;
        $this->label = $site->label;
        $this->description = $site->description ?? null;
        $this->codebaseId = $site->codebase_id ?? null;
        $this->links = $site->_links;
    }
}
