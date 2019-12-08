<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;
use AcquiaCloudApi\Response\BranchesResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Client
 * @package AcquiaCloudApi\CloudApi
 */
class Code implements CloudApi
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
     * Shows all code branches and tags in an application.
     *
     * @param string $applicationUuid
     * @return BranchesResponse
     */
    public function getAll($applicationUuid)
    {
        return new BranchesResponse(
            $this->client->request(
                'get',
                "/applications/${applicationUuid}/code"
            )
        );
    }
    
    /**
     * Deploys a code branch/tag to an environment.
     *
     * @param string $environmentUuid
     * @param string $branch
     * @return OperationResponse
     */
    public function switch($environmentUuid, $branch)
    {

        $options = [
            'form_params' => [
                'branch' => $branch,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentUuid}/code/actions/switch",
                $options
            )
        );
    }

    /**
     * Deploys code from one environment to another environment.
     *
     * @param string $environmentFromUuid
     * @param string $environmentToUuid
     * @param string $commitMessage
     */
    public function deploy($environmentFromUuid, $environmentToUuid, $commitMessage = null)
    {

        $options = [
            'form_params' => [
                'source' => $environmentFromUuid,
                'message' => $commitMessage,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentToUuid}/code",
                $options
            )
        );
    }
}
