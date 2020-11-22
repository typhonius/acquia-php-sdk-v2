<?php

namespace AcquiaCloudApi\Response;

class InsightAlertResponse extends GenericResponse
{

    /**
     * @var int $alert_id
     */
    public $alert_id;

    /**
     * @var string $uuid
     */
    public $uuid;

    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $message
     */
    public $message;

    /**
     * @var string $article_link
     */
    public $article_link;

    /**
     * @var int $severity
     */
    public $severity;

    /**
     * @var string $severity_label
     */
    public $severity_label;

    /**
     * @var string $failed_value
     */
    public $failed_value;

    /**
     * @var string $fix_details
     */
    public $fix_details;

    /**
     * @var array<string> $categories
     */
    public $categories;

    /**
     * @var object $flags
     */
    public $flags;

    /**
     * @var object $links
     */
    public $links;

    /**
     * @param object $alert
     */
    public function __construct($alert)
    {
        $this->alert_id = $alert->alert_id;
        $this->uuid = $alert->uuid;
        $this->name = $alert->name;
        $this->message = $alert->message;
        $this->article_link = $alert->article_link;
        $this->severity = $alert->severity;
        $this->severity_label = $alert->severity_label;
        $this->failed_value = $alert->failed_value;
        $this->fix_details = $alert->fix_details;
        $this->categories = $alert->categories;
        $this->flags = $alert->flags;
        $this->links = $alert->_links;
    }
}
