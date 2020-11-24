<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\RolesResponse;
use AcquiaCloudApi\Response\RoleResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Roles
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Roles extends CloudApiBase implements CloudApiInterface
{

    /**
     * Show all roles in an organization.
     *
     * @param  string $organizationUuid
     * @return RolesResponse<RoleResponse>
     */
    public function getAll($organizationUuid): RolesResponse
    {
        return new RolesResponse(
            $this->client->request('get', "/organizations/${organizationUuid}/roles")
        );
    }

    /**
     * Return details about a specific role.
     *
     * @param  string $roleUuid
     * @return RoleResponse
     */
    public function get($roleUuid): RoleResponse
    {
        return new RoleResponse(
            $this->client->request('get', "/roles/${roleUuid}")
        );
    }

    /**
     * Create a new role.
     *
     * @param  string        $organizationUuid
     * @param  string        $name
     * @param  array<string> $permissions
     * @param  null|string $description
     * @return OperationResponse
     */
    public function create($organizationUuid, $name, array $permissions, $description = null): OperationResponse
    {
        $options = [
            'json' => [
                'name' => $name,
                'permissions' => $permissions,
                'description' => $description,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/organizations/${organizationUuid}/roles", $options)
        );
    }

    /**
     * Update the permissions associated with a role.
     *
     * @param  string        $roleUuid
     * @param  array<string> $permissions
     * @return OperationResponse
     */
    public function update($roleUuid, array $permissions): OperationResponse
    {
        $options = [
            'json' => [
                'permissions' => $permissions,
            ],
        ];

        return new OperationResponse(
            $this->client->request('put', "/roles/${roleUuid}", $options)
        );
    }

    /**
     * Delete a role.
     *
     * @param  string $roleUuid
     * @return OperationResponse
     */
    public function delete($roleUuid): OperationResponse
    {
        return new OperationResponse($this->client->request('delete', "/roles/${roleUuid}"));
    }
}
