<?php

namespace AcquiaCloudApi\Response;

/**
 * Class NotificationResponse
 *
 * @package AcquiaCloudApi\Response
 */
class NotificationResponse
{
    public $uuid;
    public $event;
    public $label;
    public $description;
    public $created_at;
    public $completed_at;
    public $status;
    public $progress;
    public $context;
    public $links;

    /**
     * MemberResponse constructor.
     *
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
