<?php

namespace AcquiaCloudApi\Response;

class DomainResponse
{
    public string $hostname;

    public object $flags;

    /**
     * @var array<string>|null $ip_addresses
     */
    public ?array $ip_addresses;

    /**
     * @var array<string>|null $cnames
     */
    public ?array $cnames;

    public object $environment;

    public object $links;

    public function __construct(object $domain)
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
