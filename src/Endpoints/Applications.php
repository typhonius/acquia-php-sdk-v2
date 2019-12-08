<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;
use AcquiaCloudApi\Response\ApplicationResponse;
use AcquiaCloudApi\Response\ApplicationsResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Client
 * @package AcquiaCloudApi\CloudApi
 */
class Applications implements CloudApi
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
     * Shows all applications.
     *
     * @return ApplicationsResponse
     */
    public function getAll()
    {
        return new ApplicationsResponse($this->client->request('get', '/applications'));
    }

    /**
     * Shows information about an application.
     *
     * @param string $applicationUuid
     * @return ApplicationResponse
     */
    public function get($applicationUuid)
    {
        return new ApplicationResponse(
            $this->client->request(
                'get',
                "/applications/${applicationUuid}"
            )
        );
    }

    /**
     * Renames an application.
     *
     * @param string $applicationUuid
     * @param string $name
     * @return OperationResponse
     */
    public function rename($applicationUuid, $name)
    {

        $options = [
            'form_params' => [
                'name' => $name,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'put',
                "/applications/${applicationUuid}",
                $options
            )
        );
    }
}
