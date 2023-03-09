<?php

namespace AcquiaCloudApi\Response;

class InsightModuleResponse
{
    public int $module_id;

    public string $name;

    public string $filename;

    public string $version;

    public ?string $supported_majors;

    public ?string $recommended_major;

    public string $package;

    public string $core;

    public string $project;

    public ?string $release_date;

    public object $flags;

    /**
     * @var array<string> $tags
     */
    public array $tags;

    public function __construct(object $module)
    {
        $this->module_id = $module->module_id;
        $this->name = $module->name;
        $this->filename = $module->filename;
        $this->version = $module->version;
        $this->supported_majors = $module->supported_majors;
        $this->recommended_major = $module->recommended_major;
        $this->package = $module->package;
        $this->core = $module->core;
        $this->project = $module->project;
        $this->release_date = $module->release_date;
        $this->flags = $module->flags;
        $this->tags = $module->tags;
    }
}
