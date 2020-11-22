<?php

namespace AcquiaCloudApi\Response;

class BackupResponse extends GenericResponse
{
    /**
     * @var int $id
     */
    public $id;

    /**
     * @var object $database
     */
    public $database;

    /**
     * @var string $type
     */
    public $type;

    /**
     * @var string $startedAt
     */
    public $startedAt;

    /**
     * @var string $completedAt
     */
    public $completedAt;

    /**
     * @var object $flags
     */
    public $flags;

    /**
     * @var object $environment
     */
    public $environment;

    /**
     * @var object $links
     */
    public $links;

    /**
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
