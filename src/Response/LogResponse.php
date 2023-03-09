<?php

namespace AcquiaCloudApi\Response;

class LogResponse
{
    public string $type;

    public string $label;

    public object $flags;

    public object $links;

    /**
     */
    public function __construct(object $log)
    {
        $this->type = $log->type;
        $this->label = $log->label;
        $this->flags = $log->flags;
        $this->links = $log->_links;
    }
}
