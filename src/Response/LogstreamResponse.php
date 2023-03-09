<?php

namespace AcquiaCloudApi\Response;

class LogstreamResponse
{
    public object $logstream;

    public object $links;

    /**
     */
    public function __construct(object $logstream)
    {
        $this->logstream = $logstream->logstream;
        $this->links = $logstream->_links;
    }
}
