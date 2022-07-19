<?php

namespace AcquiaCloudApi\Response;

class InsightModuleResponse extends GenericResponse
{
    /**
     * @var int $module_id
     */
    public $module_id;

    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $filename
     */
    public $filename;

    /**
     * @var string $version
     */
    public $version;

    /**
     * @var string $supported_majors
     */
    public $supported_majors;

    /**
     * @var string $recommended_major
     */
    public $recommended_major;

    /**
     * @var string $package
     */
    public $package;

    /**
     * @var string $core
     */
    public $core;

    /**
     * @var string $project
     */
    public $project;

    /**
     * @var string $release_date
     */
    public $release_date;

    /**
     * @var object $flags
     */
    public $flags;

    /**
     * @var array<string> $tags
     */
    public $tags;

    /**
     * @param object $module
     */
    public function __construct($module)
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
