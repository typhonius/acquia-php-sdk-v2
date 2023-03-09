<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\ApplicationResponse;
use AcquiaCloudApi\Response\ApplicationsResponse;
use AcquiaCloudApi\Response\OperationResponse;
use AcquiaCloudApi\Response\TagResponse;
use AcquiaCloudApi\Response\TagsResponse;

/**
 * Class Applications
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Applications extends CloudApiBase
{
    /**
     * Shows all applications.
     *
     * @return ApplicationsResponse<ApplicationResponse>
     */
    public function getAll(): ApplicationsResponse
    {
        return new ApplicationsResponse($this->client->request('get', '/applications'));
    }

    /**
     * Shows information about an application.
     */
    public function get(string $applicationUuid): ApplicationResponse
    {
        return new ApplicationResponse(
            $this->client->request(
                'get',
                "/applications/$applicationUuid"
            )
        );
    }

    /**
     * Renames an application.
     */
    public function rename(string $applicationUuid, string $name): OperationResponse
    {

        $options = [
            'json' => [
                'name' => $name,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'put',
                "/applications/$applicationUuid",
                $options
            )
        );
    }

    /**
     * Returns a list of application tags associated with this application.
     *
     * @return TagsResponse<TagResponse>
     */
    public function getAllTags(string $applicationUuid): TagsResponse
    {

        return new TagsResponse(
            $this->client->request(
                'get',
                "/applications/$applicationUuid/tags"
            )
        );
    }

    /**
     * Creates a new application tag.
     */
    public function createTag(string $applicationUuid, string $name, string $color): OperationResponse
    {

        $options = [
            'json' => [
                'name' => $name,
                'color' => $color,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'post',
                "/applications/$applicationUuid/tags",
                $options
            )
        );
    }

    /**
     * Deletes an application tag.
     */
    public function deleteTag(string $applicationUuid, string $tagName): OperationResponse
    {

        return new OperationResponse(
            $this->client->request(
                'delete',
                "/applications/$applicationUuid/tags/$tagName"
            )
        );
    }
}
