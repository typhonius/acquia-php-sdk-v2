<?php

namespace AcquiaCloudApi\Response;

/**
 * Class DomainResponse
 *
 * @package AcquiaCloudApi\Response
 */
class DomainResponse
{

    public $hostname;
    public $flags;
    public $ip_addresses;
    public $cnames;
    public $environment;
    public $links;

    /**
     * DomainResponse constructor.
     *
     * @param object $domain
     */
    public function __construct($domain)
    {
        $this->hostname = $domain->hostname;
        $this->flags = $domain->flags;
        $this->environment = $domain->environment;
        if (property_exists($domain, 'ip_addresses')) {
            $this->ip_addresses = $domain->ip_addresses;
        }
        if (property_exists($domain, 'cnames')) {
            $this->cnames = $domain->cnames;
        }
        $this->links = $domain->_links;
    }
}
