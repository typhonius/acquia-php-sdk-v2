<?php

namespace AcquiaCloudApi\Response;

/**
 * Class DomainResponse
 * @package AcquiaCloudApi\Response
 */
class DomainResponse
{

    public $hostname;
    public $flags;
    public $environment;

    /**
     * DomainResponse constructor.
     * @param object $domain
     */
    public function __construct($domain)
    {
        $this->hostname = $domain->hostname;
        $this->flags = $domain->flags;
        $this->environment = $domain->environment;
    }
}
