<?php

namespace AcquiaCloudApi\Response;

/**
 * Class LogstreamResponse
 *
 * @package AcquiaCloudApi\Response
 */
class LogstreamResponse
{

    public $logstream;
    public $links;

    /**
     * LogstreamResponse constructor.
     *
     * @param object $logstream
     */
    public function __construct($logstream)
    {
        $this->logstream = $logstream->logstream;
        $this->links = $logstream->_links;
    }
}
