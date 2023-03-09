<?php

namespace AcquiaCloudApi\Response;

class InsightAlertResponse
{
    public int $alert_id;

    public string $uuid;

    public string $name;

    public string $message;

    public string $article_link;

    public int $severity;

    public string $severity_label;

    public string $failed_value;

    public string $fix_details;

    /**
     * @var array<string> $categories
     */
    public array $categories;

    public object $flags;

    public object $links;

    /**
     */
    public function __construct(object $alert)
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
