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
     * @param string $organizationUuid
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
     * @param string $roleUuid
     *
     * @return RoleResponse
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
     * @param string $organizationUuid
     * @param string $name
     * @param array<string> $permissions
     * @param string|null $description
     *
     * @return OperationResponse
     */
    public function create(string $organizationUuid, string $name, array $permissions, string $description = null): OperationResponse
    {
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
     * @param string $roleUuid
     * @param array<string> $permissions
     *
     * @return OperationResponse
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
     * @param string $roleUuid
     *
     * @return OperationResponse
     */
    public function delete(string $roleUuid): OperationResponse
    {
        return new OperationResponse($this->client->request('delete', "/roles/$roleUuid"));
    }
}
