<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\IdeResponse;
use AcquiaCloudApi\Response\IdesResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Ides
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Ides extends CloudApiBase
{
    /**
     * Returns a list of remote IDEs.
     *
     * @param string $applicationUuid The application ID
     *
     * @return IdesResponse<IdeResponse>
     */
    public function getAll(string $applicationUuid): IdesResponse
    {
        return new IdesResponse(
            $this->client->request(
                'get',
                "/applications/$applicationUuid/ides"
            )
        );
    }

    /**
     * Returns a list of the current user's IDEs.
     *
     * @return IdesResponse<IdeResponse>
     */
    public function getMine(): IdesResponse
    {
        return new IdesResponse(
            $this->client->request(
                'get',
                '/account/ides'
            )
        );
    }

    /**
     * Get remote IDE info.
     *
     * @param string $ideUuid The Remote IDE universally unique identifier.
     *
     */
    public function get(string $ideUuid): IdeResponse
    {
        return new IdeResponse(
            $this->client->request(
                'get',
                "/ides/$ideUuid"
            )
        );
    }

    /**
     * Creates a new remote IDE.
     *
     *
     */
    public function create(string $applicationUuid, string $label): OperationResponse
    {

        $options = [
            'json' => [
                'label' => $label,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/applications/$applicationUuid/ides", $options)
        );
    }

    /**
     * De-provisions a specific Remote IDE.
     *
     *
     */
    public function delete(string $ideUuid): OperationResponse
    {
        return new OperationResponse(
            $this->client->request('delete', "/ides/$ideUuid")
        );
    }
}
