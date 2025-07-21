<?php

namespace AcquiaCloudApi\Response;

class CodebaseEnvironmentResponse
{
    public object $links;

    public string $id;

    public string $name;

    public string $label;

    public string $description;

    public string $status;

    public string $reference;

    public object $flags;

    /**
     * @var array<string, mixed> $properties
     */
    public array $properties;

    public object $codebase;

    public function __construct(object $environment)
    {
        $this->links = $environment->_links;
        $this->id = $environment->id;
        $this->name = $environment->name;
        $this->label = $environment->label;
        $this->description = $environment->description;
        $this->status = $environment->status;
        $this->reference = $environment->reference;
        $this->flags = $environment->flags;
        $this->properties = (array) ($environment->properties ?? []);

        // Handle embedded codebase or direct codebase reference
        if (isset($environment->_embedded->codebase)) {
            $this->codebase = $environment->_embedded->codebase;
        } elseif (isset($environment->codebase)) {
            $this->codebase = $environment->codebase;
        } else {
            $this->codebase = (object) [];
        }
    }
}
