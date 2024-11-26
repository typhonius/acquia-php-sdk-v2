<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\BranchesResponse;
use AcquiaCloudApi\Response\BranchResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Code
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Code extends CloudApiBase
{
    /**
     * Shows all code branches and tags in an application.
     *
     * @return BranchesResponse<BranchResponse>
     */
    public function getAll(string $applicationUuid): BranchesResponse
    {
        return new BranchesResponse(
            $this->client->request(
                'get',
                "/applications/$applicationUuid/code"
            )
        );
    }

    /**
     * Deploys a code branch/tag to an environment.
     */
    public function switch(string $environmentUuid, string $branch): OperationResponse
    {

        $options = [
            'json' => [
                'branch' => $branch,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/$environmentUuid/code/actions/switch",
                $options
            )
        );
    }

    /**
     * Deploys code from one environment to another environment.
     */
    public function deploy(
        string $environmentFromUuid,
        string $environmentToUuid,
        ?string $commitMessage = null
    ): OperationResponse {

        $options = [
            'json' => [
                'source' => $environmentFromUuid,
                'message' => $commitMessage,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/$environmentToUuid/code",
                $options
            )
        );
    }
}
