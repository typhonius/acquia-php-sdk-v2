<?php

namespace AcquiaCloudApi\Response;

class ReferenceResponse
{
    public string $id;

    public string $name;

    public string $type;

    public ?string $commit_id = null;

    public ?string $commit_message = null;

    public ?string $commit_author = null;

    public ?string $commit_date = null;

    public object $links;

    /**
     * ReferenceResponse constructor.
     *
     * @param object $reference
     */
    public function __construct(object $reference)
    {
        $this->id = $reference->id;
        $this->name = $reference->name;
        $this->type = $reference->type;
        $this->commit_id = $reference->commit_id ?? null;
        $this->commit_message = $reference->commit_message ?? null;
        $this->commit_author = $reference->commit_author ?? null;
        $this->commit_date = $reference->commit_date ?? null;
        $this->links = $reference->_links;
    }
}
