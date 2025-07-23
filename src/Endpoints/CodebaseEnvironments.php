<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\CodebaseEnvironmentResponse;
use AcquiaCloudApi\Response\CodebaseEnvironmentsResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class CodebaseEnvironments
 *
 * @package AcquiaCloudApi\CloudApi
 */
class CodebaseEnvironments extends CloudApiBase
{
    /**
     * Returns a list of environments for a codebase.
     */
    public function getAll(string $codebaseId): CodebaseEnvironmentsResponse
    {
        return new CodebaseEnvironmentsResponse(
            $this->client->request(
                'get',
                "/api/codebases/$codebaseId/environments"
            )
        );
    }

    /**
     * Returns information about a specific environment for a codebase.
     */
    public function get(string $codebaseId, string $environmentId): CodebaseEnvironmentResponse
    {
        return new CodebaseEnvironmentResponse(
            $this->client->request(
                'get',
                "/api/codebases/$codebaseId/environments/$environmentId"
            )
        );
    }

    /**
     * Returns information about a specific environment by ID.
     */
    public function getById(string $environmentId): CodebaseEnvironmentResponse
    {
        return new CodebaseEnvironmentResponse(
            $this->client->request(
                'get',
                "/api/environments/$environmentId"
            )
        );
    }

    /**
     * Updates the properties for an environment.
     *
     * @param array<string, mixed> $properties
     */
    public function update(string $environmentId, array $properties): OperationResponse
    {
        $options = [
            'json' => [
                'properties' => $properties
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'put',
                "/api/environments/$environmentId",
                $options
            )
        );
    }

    /**
     * Associates an environment with a private network.
     */
    public function associatePrivateNetwork(string $environmentId, string $privateNetworkId): OperationResponse
    {
        $options = [
            'json' => [
                'private_network_id' => $privateNetworkId
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'put',
                "/api/environments/$environmentId/private-network",
                $options
            )
        );
    }

    /**
     * Disassociates an environment from a private network.
     */
    public function disassociatePrivateNetwork(string $environmentId): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'delete',
                "/api/environments/$environmentId/private-network"
            )
        );
    }

    /**
     * Gets environments associated with a private network.
     */
    public function getByPrivateNetwork(string $privateNetworkId): CodebaseEnvironmentsResponse
    {
        return new CodebaseEnvironmentsResponse(
            $this->client->request(
                'get',
                "/api/private-networks/$privateNetworkId/environments"
            )
        );
    }

    /**
     * Gets environments associated with a site.
     */
    public function getBySite(string $siteId): CodebaseEnvironmentsResponse
    {
        return new CodebaseEnvironmentsResponse(
            $this->client->request(
                'get',
                "/api/sites/$siteId/environments"
            )
        );
    }
}
