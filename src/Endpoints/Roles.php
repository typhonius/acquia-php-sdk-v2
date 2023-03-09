<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\OperationResponse;
use AcquiaCloudApi\Response\RoleResponse;
use AcquiaCloudApi\Response\RolesResponse;

/**
 * Class Roles
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Roles extends CloudApiBase
{
    /**
     * Show all roles in an organization.
     *
     *
     * @return RolesResponse<RoleResponse>
     */
    public function getAll(string $organizationUuid): RolesResponse
    {
        return new RolesResponse(
            $this->client->request('get', "/organizations/$organizationUuid/roles")
        );
    }

    /**
     * Return details about a specific role.
     *
     *
     */
    public function get(string $roleUuid): RoleResponse
    {
        return new RoleResponse(
            $this->client->request('get', "/roles/$roleUuid")
        );
    }

    /**
     * Create a new role.
     *
     * @param array<string> $permissions
     * @param string|null $description
     *
     */
    public function create(
        string $organizationUuid,
        string $name,
        array $permissions,
        string $description = null
    ): OperationResponse {
        $options = [
            'json' => [
                'name' => $name,
                'permissions' => $permissions,
                'description' => $description,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/organizations/$organizationUuid/roles", $options)
        );
    }

    /**
     * Update the permissions associated with a role.
     *
     * @param array<string> $permissions
     *
     */
    public function update(string $roleUuid, array $permissions): OperationResponse
    {
        $options = [
            'json' => [
                'permissions' => $permissions,
            ],
        ];

        return new OperationResponse(
            $this->client->request('put', "/roles/$roleUuid", $options)
        );
    }

    /**
     * Delete a role.
     *
     *
     */
    public function delete(string $roleUuid): OperationResponse
    {
        return new OperationResponse($this->client->request('delete', "/roles/$roleUuid"));
    }
}
