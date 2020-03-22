<?php

namespace AcquiaCloudApi\Response;

/**
 * Class InsightModuleResponse
 *
 * @package AcquiaCloudApi\Response
 */
class InsightModuleResponse
{

    public $module_id;
    public $name;
    public $filename;
    public $version;
    public $supported_majors;
    public $recommended_major;
    public $package;
    public $core;
    public $project;
    public $release_date;
    public $flags;
    public $tags;

    /**
     * InsightModuleResponse constructor.
     *
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
