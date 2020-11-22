<?php

namespace AcquiaCloudApi\Response;

class DomainResponse extends GenericResponse
{
    /**
     * @var string $hostname
     */
    public $hostname;

    /**
     * @var object $flags
     */
    public $flags;

    /**
     * @var array<string>|null $ip_addresses
     */
    public $ip_addresses;

    /**
     * @var array<string>|null $cnames
     */
    public $cnames;

    /**
     * @var object $environment
     */
    public $environment;

    /**
     * @var object $links
     */
    public $links;

    /**
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
