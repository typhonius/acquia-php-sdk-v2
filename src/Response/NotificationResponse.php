<?php

namespace AcquiaCloudApi\Response;

class NotificationResponse
{
    public string $uuid;

    public string $event;

    public string $label;

    public string $description;

    public string $created_at;

    public ?string $completed_at;

    public string $status;

    public int $progress;

    public object $context;

    public ?object $links;

    public function __construct(object $notification)
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
