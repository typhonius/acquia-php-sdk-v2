<?php

namespace AcquiaCloudApi\Response;

/**
 * Class InsightAlertResponse
 *
 * @package AcquiaCloudApi\Response
 */
class InsightAlertResponse
{

    public $alert_id;
    public $uuid;
    public $name;
    public $message;
    public $article_link;
    public $severity;
    public $severity_label;
    public $failed_value;
    public $fix_details;
    public $categories;
    public $flags;
    public $links;

    /**
     * InsightAlertResponse constructor.
     *
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
