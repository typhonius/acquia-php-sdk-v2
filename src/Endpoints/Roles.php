<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;
use AcquiaCloudApi\Response\ApplicationResponse;
use AcquiaCloudApi\Response\ApplicationsResponse;
use AcquiaCloudApi\Response\RolesResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Client
 * @package AcquiaCloudApi\CloudApi
 */
class Roles implements CloudApi
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
     * Update the permissions associated with a role.
     *
     * @param string $roleUuid
     * @param array  $permissions
     * @return OperationResponse
     */
    public function updateRole($roleUuid, array $permissions)
    {
        $options = [
            'form_params' => [
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
     * @param string $roleUuid
     * @return OperationResponse
     */
    public function deleteRole($roleUuid)
    {
        return new OperationResponse($this->client->request('delete', "/roles/${roleUuid}"));
    }
}
