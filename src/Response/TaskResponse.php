<?php

namespace AcquiaCloudApi\Response;

/**
 * Class TaskResponse
 * @package AcquiaCloudApi\Response
 */
class TaskResponse
{

    public $uuid;
    public $user;
    public $name;
    public $description;
    public $title;
    public $createdAt;
    public $startedAt;
    public $completedAt;
    public $status;
    public $type;
    public $metadata;

    /**
     * TaskResponse constructor.
     * @param object $task
     */
    public function __construct($task)
    {
        $this->uuid = $task->uuid;
        $this->user = $task->user;
        $this->name = $task->name;
        $this->description = $task->description;
        $this->title = $task->title;
        $this->createdAt = $task->created_at;
        $this->startedAt = $task->started_at;
        $this->completedAt = $task->completed_at;
        $this->status = $task->status;
        $this->type = $task->type;
        $this->metadata = $task->metadata;
    }
}
