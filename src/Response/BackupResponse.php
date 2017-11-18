<?php

namespace AcquiaCloudApi\Response;

/**
 * Class BackupResponse
 * @package AcquiaCloudApi\Response
 */
class BackupResponse
{

    public $id;
    public $database;
    public $type;
    public $startedAt;
    public $completedAt;
    public $flags;
    public $environment;
    public $links;

    /**
     * BackupResponse constructor.
     * @param object $backup
     */
    public function __construct($backup)
    {
        $this->id = $backup->id;
        $this->database = $backup->database;
        $this->type = $backup->type;
        $this->startedAt = $backup->started_at;
        $this->completedAt = $backup->completed_at;
        $this->flags = $backup->flags;
        $this->environment = $backup->environment;
        $this->links = $backup->_links;
    }
}
