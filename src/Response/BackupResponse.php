<?php

namespace AcquiaCloudApi\Response;

class BackupResponse
{
    public int $id;

    public object $database;

    public string $type;

    public string $startedAt;

    public string $completedAt;

    public object $flags;

    public object $environment;

    public object $links;

    /**
     */
    public function __construct(object $backup)
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
