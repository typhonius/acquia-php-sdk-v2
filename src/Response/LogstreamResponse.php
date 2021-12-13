<?php

namespace AcquiaCloudApi\Response;

class LogstreamResponse
{
    /**
     * @var object $logstream
     */

    public $logstream;

    /**
     * @var object $links
     */
    public $links;

    /**
     * @param object $logstream
     */
    public function __construct($logstream)
    {
        $this->logstream = $logstream->logstream;
        $this->links = $logstream->_links;
    }
}
