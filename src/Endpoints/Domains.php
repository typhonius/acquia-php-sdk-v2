<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\DomainResponse;
use AcquiaCloudApi\Response\DomainsResponse;
use AcquiaCloudApi\Response\MetricResponse;
use AcquiaCloudApi\Response\MetricsResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Domains
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Domains extends CloudApiBase
{
    /**
     * Shows all domains on an environment.
     *
     * @param string $environmentUuid
     *
     * @return DomainsResponse<DomainResponse>
     */
    public function getAll(string $environmentUuid): DomainsResponse
    {
        return new DomainsResponse(
            $this->client->request(
                'get',
                "/environments/$environmentUuid/domains"
            )
        );
    }

    /**
     * Return details about a domain.
     *
     * @param string $environmentUuid
     * @param string $domain
     *
     * @return DomainResponse
     */
    public function get(string $environmentUuid, string $domain): DomainResponse
    {
        return new DomainResponse(
            $this->client->request(
                'get',
                "/environments/$environmentUuid/domains/$domain"
            )
        );
    }

    /**
     * Adds a domain to an environment.
     *
     * @param string $environmentUuid
     * @param string $hostname
     *
     * @return OperationResponse
     */
    public function create(string $environmentUuid, string $hostname): OperationResponse
    {

        $options = [
            'json' => [
                'hostname' => $hostname,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/environments/$environmentUuid/domains", $options)
        );
    }

    /**
     * Deletes a domain from an environment.
     *
     * @param string $environmentUuid
     * @param string $domain
     *
     * @return OperationResponse
     */
    public function delete(string $environmentUuid, string $domain): OperationResponse
    {
        return new OperationResponse(
            $this->client->request('delete', "/environments/$environmentUuid/domains/$domain")
        );
    }

    /**
     * Purges cache for selected domains in an environment.
     *
     * @param string $environmentUuid
     * @param array<string> $domains
     *
     * @return OperationResponse
     */
    public function purge(string $environmentUuid, array $domains): OperationResponse
    {
        $options = [
            'json' => [
                'domains' => $domains,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/$environmentUuid/actions/clear-caches",
                $options
            )
        );
    }

    /**
     * Purges cache for a single domain in an environment.
     *
     * @param string $environmentUuid
     * @param string $domain
     *
     * @return OperationResponse
     */
    public function clearDomainCache(string $environmentUuid, string $domain): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/$environmentUuid/domains/$domain/actions/clear-caches"
            )
        );
    }

    /**
     * Retrieves the scan data for a domain name that is part of this
     * environment.
     *
     * @param string $environmentUuid
     * @param string $domain
     *
     * @return MetricsResponse<MetricResponse>
     */
    public function metrics(string $environmentUuid, string $domain): MetricsResponse
    {
        return new MetricsResponse(
            $this->client->request(
                'get',
                "/environments/$environmentUuid/domains/$domain/metrics/uptime"
            )
        );
    }

    /**
     * Returns details about the domain.
     *
     * @param string $environmentUuid
     * @param string $domain
     *
     * @return DomainResponse
     */
    public function status(string $environmentUuid, string $domain): DomainResponse
    {
        return new DomainResponse(
            $this->client->request(
                'get',
                "/environments/$environmentUuid/domains/$domain/status"
            )
        );
    }
}
