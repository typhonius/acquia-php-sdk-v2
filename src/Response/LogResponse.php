<?php

namespace AcquiaCloudApi\Response;

/**
 * Class LogResponse
 *
 * @package AcquiaCloudApi\Response
 */
class LogResponse
{

    public $type;
    public $label;
    public $flags;
    public $links;

    /**
     * LogResponse constructor.
     *
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
