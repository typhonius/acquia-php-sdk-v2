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

    public string $code_switch_status;

    public object $flags;

    /**
     * @var array<string, mixed> $properties
     */
    public array $properties;

    public object $codebase;

    public ?string $codebase_uuid = null;

    public function __construct(object $environment)
    {
        $this->links = $environment->_links;
        $this->id = $environment->id;
        $this->name = $environment->name;
        $this->label = $environment->label;
        $this->description = $environment->description;
        $this->status = $environment->status;
        $this->reference = $environment->reference;
        $this->code_switch_status = $environment->code_switch_status ?? 'IDLE';
        $this->flags = $environment->flags;
        $this->properties = (array) ($environment->properties ?? []);

        // Initialize codebase as empty object by default
        $this->codebase = new \stdClass();

        // Handle embedded codebase or direct codebase reference
        if (isset($environment->_embedded->codebase)) {
            $hasId = isset($environment->_embedded->codebase->id);
            $this->codebase_uuid = $hasId ? $environment->_embedded->codebase->id : null;
        } elseif (isset($environment->codebase)) {
            $hasId = isset($environment->codebase->id);
            $this->codebase_uuid = $hasId ? $environment->codebase->id : null;
        }
    }
}
