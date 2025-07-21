<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\OperationResponse;
use AcquiaCloudApi\Response\SiteResponse;
use AcquiaCloudApi\Response\SitesResponse;
use AcquiaCloudApi\Response\CodebaseEnvironmentsResponse;

/**
 * Class Sites
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Sites extends CloudApiBase
{
    /**
     * Retrieves a list of sites accessible by the user.
     *
     * @return SitesResponse<SiteResponse>
     */
    public function getAll(): SitesResponse
    {
        return new SitesResponse($this->client->request('get', '/sites'));
    }

    /**
     * Retrieves a site details by its ID.
     */
    public function get(string $siteId): SiteResponse
    {
        return new SiteResponse(
            $this->client->request(
                'get',
                "/sites/$siteId"
            )
        );
    }

    /**
     * Creates a site for a codebase.
     */
    public function create(string $name, string $label, string $codebaseId, ?string $description = null): OperationResponse
    {
        $options = [
            'json' => [
                'name' => $name,
                'label' => $label,
                'codebase_id' => $codebaseId,
            ],
        ];

        if ($description !== null) {
            $options['json']['description'] = $description;
        }

        return new OperationResponse(
            $this->client->request('post', '/sites', $options)
        );
    }

    /**
     * Update a site details by its id.
     */
    public function update(string $siteId, ?string $name = null, ?string $label = null, ?string $description = null): OperationResponse
    {
        $options = ['json' => []];

        if ($name !== null) {
            $options['json']['name'] = $name;
        }

        if ($label !== null) {
            $options['json']['label'] = $label;
        }

        if ($description !== null) {
            $options['json']['description'] = $description;
        }

        return new OperationResponse(
            $this->client->request('put', "/sites/$siteId", $options)
        );
    }

    /**
     * Deletes a site by its ID.
     */
    public function delete(string $siteId): OperationResponse
    {
        return new OperationResponse(
            $this->client->request('delete', "/sites/$siteId")
        );
    }

    /**
     * Retrieves a list of sites associated with an environment.
     *
     * @return SitesResponse<SiteResponse>
     */
    public function getByEnvironment(string $environmentId): SitesResponse
    {
        return new SitesResponse(
            $this->client->request('get', "/environments/$environmentId/sites")
        );
    }

    /**
     * Retrieves a list of sites associated with an organization.
     *
     * @return SitesResponse<SiteResponse>
     */
    public function getByOrganization(string $organizationUuid): SitesResponse
    {
        return new SitesResponse(
            $this->client->request('get', "/organizations/$organizationUuid/sites")
        );
    }

    /**
     * Retrieves a list of sites associated with a team.
     *
     * @return SitesResponse<SiteResponse>
     */
    public function getByTeam(string $teamId): SitesResponse
    {
        return new SitesResponse(
            $this->client->request('get', "/teams/$teamId/sites")
        );
    }

    /**
     * Retrieves all environments by site.
     *
     * @return CodebaseEnvironmentsResponse
     */
    public function getEnvironments(string $siteId): CodebaseEnvironmentsResponse
    {
        return new CodebaseEnvironmentsResponse(
            $this->client->request('get', "/sites/$siteId/environments")
        );
    }
}
