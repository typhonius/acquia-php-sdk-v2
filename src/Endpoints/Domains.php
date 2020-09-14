<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\DomainsResponse;
use AcquiaCloudApi\Response\DomainResponse;
use AcquiaCloudApi\Response\OperationResponse;
use AcquiaCloudApi\Response\MetricsResponse;

/**
 * Class Domains
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Domains extends CloudApiBase implements CloudApiInterface
{

    /**
     * Shows all domains on an environment.
     *
     * @param  string $environmentUuid
     * @return DomainsResponse
     */
    public function getAll($environmentUuid)
    {
        return new DomainsResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/domains"
            )
        );
    }

    /**
     * Return details about a domain.
     *
     * @param  string $environmentUuid
     * @param  string $domain
     * @return DomainResponse
     */
    public function get($environmentUuid, $domain)
    {
        return new DomainResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/domains/${domain}"
            )
        );
    }

    /**
     * Adds a domain to an environment.
     *
     * @param  string $environmentUuid
     * @param  string $hostname
     * @return OperationResponse
     */
    public function create($environmentUuid, $hostname)
    {

        $options = [
            'json' => [
                'hostname' => $hostname,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/environments/${environmentUuid}/domains", $options)
        );
    }

    /**
     * Deletes a domain from an environment.
     *
     * @param  string $environmentUuid
     * @param  string $domain
     * @return OperationResponse
     */
    public function delete($environmentUuid, $domain)
    {
        return new OperationResponse(
            $this->client->request('delete', "/environments/${environmentUuid}/domains/${domain}")
        );
    }

    /**
     * Purges varnish for selected domains in an environment.
     *
     * @param  string $environmentUuid
     * @param  array  $domains
     * @return OperationResponse
     */
    public function purge($environmentUuid, array $domains)
    {

        $options = [
            'json' => [
                'domains' => $domains,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentUuid}/domains/actions/clear-varnish",
                $options
            )
        );
    }

    /**
     * Retrieves the scan data for a domain name that is part of this environment.
     *
     * @param  string $environmentUuid
     * @param  string $domain
     * @return MetricsResponse
     */
    public function metrics($environmentUuid, $domain)
    {
        return new MetricsResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/domains/${domain}/metrics/uptime"
            )
        );
    }

    /**
     * Returns details about the domain.
     *
     * @param  string $environmentUuid
     * @param  string $domain
     * @return DomainResponse
     */
    public function status($environmentUuid, $domain)
    {
        return new DomainResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/domains/${domain}/status"
            )
        );
    }
}
