<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\ApplicationResponse;
use AcquiaCloudApi\Response\ApplicationsResponse;
use AcquiaCloudApi\Response\TagResponse;
use AcquiaCloudApi\Response\TagsResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Applications
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Applications extends CloudApiBase implements CloudApiInterface
{

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
     * @param  string $applicationUuid
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
     * @param  string $applicationUuid
     * @param  string $name
     * @return OperationResponse
     */
    public function rename($applicationUuid, $name)
    {

        $options = [
            'json' => [
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

    /**
     * Returns a list of application tags associated with this application.
     *
     * @param  string $applicationUuid
     * @return TagsResponse
     */
    public function getAllTags($applicationUuid)
    {

        return new TagsResponse(
            $this->client->request(
                'get',
                "/applications/${applicationUuid}/tags"
            )
        );
    }

    /**
     * Creates a new application tag.
     *
     * @param  string $applicationUuid
     * @param  string $name
     * @param  string $color
     * @return OperationResponse
     */
    public function createTag($applicationUuid, $name, $color)
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
                "/applications/${applicationUuid}/tags",
                $options
            )
        );
    }

    /**
     * Deletes an application tag.
     *
     * @param  string $applicationUuid
     * @param  string $tagName
     * @return OperationResponse
     */
    public function deleteTag($applicationUuid, $tagName)
    {

        return new OperationResponse(
            $this->client->request(
                'delete',
                "/applications/${applicationUuid}/tags/${tagName}"
            )
        );
    }
}
