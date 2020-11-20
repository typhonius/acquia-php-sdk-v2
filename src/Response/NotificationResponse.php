<?php

namespace AcquiaCloudApi\Response;

class NotificationResponse
{
    /**
     * @var string $uuid
     */
    public $uuid;

    /**
     * @var string $event
     */
    public $event;

    /**
     * @var string $label
     */
    public $label;

    /**
     * @var string $description
     */
    public $description;

    /**
     * @var string $created_at
     */
    public $created_at;

    /**
     * @var string $completed_at
     */
    public $completed_at;

    /**
     * @var string $status
     */
    public $status;

    /**
     * @var int $progress
     */
    public $progress;

    /**
     * @var object $context
     */
    public $context;

    /**
     * @var object|null $links
     */
    public $links;

    /**
     * @param object $notification
     */
    public function __construct($notification)
    {
        $this->uuid = $notification->uuid;
        $this->event = $notification->event;
        $this->label = $notification->label;
        $this->description = $notification->description;
        $this->created_at = $notification->created_at;
        $this->completed_at = $notification->completed_at;
        $this->status = $notification->status;
        $this->progress = $notification->progress;
        $this->context = $notification->context;
        if (property_exists($notification, '_links')) {
            $this->links = $notification->_links;
        }
    }
}
