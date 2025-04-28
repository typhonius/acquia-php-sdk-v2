<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\CodebasesResponse;
use AcquiaCloudApi\Response\CodebaseResponse;

class Codebases extends CloudApiBase
{
    /**
     * Shows all codebases.
     *
     * @return CodebasesResponse
     */
    public function getAll(): CodebasesResponse
    {
        return new CodebasesResponse(
            $this->client->request(
                'get',
                "/codebases"
            )
        );
    }

    /**
     * Shows information about a specific codebase.
     *
     * @param string $codebaseUuid The codebase UUID.
     * @return CodebaseResponse
     */
    public function get(string $codebaseUuid): CodebaseResponse
    {
        return new CodebaseResponse(
            $this->client->request(
                'get',
                "/codebases/${codebaseUuid}"
            )
        );
    }
}
