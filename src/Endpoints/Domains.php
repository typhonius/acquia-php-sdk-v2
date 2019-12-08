<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;
use AcquiaCloudApi\Response\DomainsResponse;
use AcquiaCloudApi\Response\DomainResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Client
 * @package AcquiaCloudApi\CloudApi
 */
class Domains implements CloudApi
{

    /** @var ClientInterface The API client. */
    protected $client;

    /**
     * Client constructor.
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Shows all domains on an environment.
     *
     * @param string $environmentUuid
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
     * @param string $environmentUuid
     * @param string $domain
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
     * @param string $environmentUuid
     * @param string $hostname
     * @return OperationResponse
     */
    public function create($environmentUuid, $hostname)
    {

        $options = [
            'form_params' => [
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
     * @param string $environmentUuid
     * @param string $domain
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
     * @param string $environmentUuid
     * @param array  $domains
     * @return OperationResponse
     */
    public function purge($environmentUuid, array $domains)
    {

        $options = [
            'form_params' => [
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
}
