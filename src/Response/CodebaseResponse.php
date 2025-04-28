<?php

namespace AcquiaCloudApi\Response;

/**
 * Class CodebaseResponse
 * @package AcquiaCloudApi\Response
 */
class CodebaseResponse
{
    public $id;
    public $label;
    public $region;
    public $vcs_url;
    public $repository_id;
    public $created_at;
    public $updated_at;
    public $description;
    public $flags;
    public $hash;
    public $applications_total;
    public $links;
    public $embedded;

    /**
     * CodebaseResponse constructor.
     * @param object $codebase
     */
    public function __construct($codebase)
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
