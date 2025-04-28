<?php

namespace AcquiaCloudApi\Response;

class CodebaseResponse
{
    public string $id;

    public string $label;

    public string $region;

    public string $vcs_url;

    public string $repository_id;

    public string $created_at;

    public string $updated_at;

    public string $description;

    public ?object $flags = null;

    public string $hash;

    public int $applications_total;

    public object $links;

    public ?object $embedded = null;

    /**
     * CodebaseResponse constructor.
     */
    public function __construct(object $codebase)
    {
        $this->id = $codebase->id;
        $this->label = $codebase->label;
        $this->region = $codebase->region;
        $this->vcs_url = $codebase->vcs_url;
        $this->repository_id = $codebase->repository_id;
        $this->created_at = $codebase->created_at;
        $this->updated_at = $codebase->updated_at;
        $this->description = $codebase->description;
        $this->flags = $codebase->flags;
        $this->hash = $codebase->hash;
        $this->applications_total = $codebase->applications_total;
        $this->links = $codebase->_links;
        $this->embedded = isset($codebase->_embedded) ? $codebase->_embedded : null;
    }
}
