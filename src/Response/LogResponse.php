<?php

namespace AcquiaCloudApi\Response;

class LogResponse
{
    /**
     * @var string $type
     */
    public $type;

    /**
     * @var string $label
     */
    public $label;

    /**
     * @var object $flags
     */
    public $flags;

    /**
     * @var object $links
     */
    public $links;

    /**
     * @param object $log
     */
    public function __construct($log)
    {
        $this->type = $log->type;
        $this->label = $log->label;
        $this->flags = $log->flags;
        $this->links = $log->_links;
    }
}
