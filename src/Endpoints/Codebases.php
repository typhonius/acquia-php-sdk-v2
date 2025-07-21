<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\CodebasesResponse;
use AcquiaCloudApi\Response\CodebaseResponse;
use AcquiaCloudApi\Response\ApplicationsResponse;
use AcquiaCloudApi\Response\ReferencesResponse;
use AcquiaCloudApi\Response\ReferenceResponse;
use AcquiaCloudApi\Response\BulkCodeSwitchResponse;
use AcquiaCloudApi\Response\CodebaseEnvironmentsResponse;
use AcquiaCloudApi\Response\SitesResponse;
use AcquiaCloudApi\Response\OperationResponse;

class Codebases extends CloudApiBase
{
    /**
     * Shows all codebases.
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
     */
    public function get(string $codebaseUuid): CodebaseResponse
    {
        return new CodebaseResponse(
            $this->client->request(
                'get',
                "/codebases/$codebaseUuid"
            )
        );
    }

    /**
     * Shows all codebases for a subscription.
     *
     * @param string $subscriptionUuid The subscription UUID.
     */
    public function getBySubscription(string $subscriptionUuid): CodebasesResponse
    {
        return new CodebasesResponse(
            $this->client->request(
                'get',
                "/subscriptions/$subscriptionUuid/codebases"
            )
        );
    }

    /**
     * Shows all applications associated with a codebase.
     *
     * @param string $codebaseUuid The codebase UUID.
     */
    public function getApplications(string $codebaseUuid): ApplicationsResponse
    {
        return new ApplicationsResponse(
            $this->client->request(
                'get',
                "/codebases/$codebaseUuid/applications"
            )
        );
    }

    /**
     * Shows all git references for a codebase.
     *
     * @param string $codebaseUuid The codebase UUID.
     */
    public function getReferences(string $codebaseUuid): ReferencesResponse
    {
        return new ReferencesResponse(
            $this->client->request(
                'get',
                "/codebases/$codebaseUuid/references"
            )
        );
    }

    /**
     * Shows information about a specific git reference.
     *
     * @param string $codebaseUuid The codebase UUID.
     * @param string $referenceName The reference name (branch or tag).
     */
    public function getReference(string $codebaseUuid, string $referenceName): ReferenceResponse
    {
        return new ReferenceResponse(
            $this->client->request(
                'get',
                "/codebases/$codebaseUuid/references/$referenceName"
            )
        );
    }

    /**
     * Shows all sites associated with a codebase.
     *
     * @param string $codebaseUuid The codebase UUID.
     */
    public function getSites(string $codebaseUuid): SitesResponse
    {
        return new SitesResponse(
            $this->client->request(
                'get',
                "/codebases/$codebaseUuid/sites"
            )
        );
    }
    /**
     * Shows all environments associated with a codebase.
     *
     * @param string $codebaseUuid The codebase UUID.
     */
    public function getEnvironments(string $codebaseUuid): CodebaseEnvironmentsResponse
    {
        return new CodebaseEnvironmentsResponse(
            $this->client->request(
                'get',
                "/codebases/$codebaseUuid/environments"
            )
        );
    }

    /**
     * Retrieves a list of bulk code switches performed on a codebase.
     *
     * @param string $codebaseUuid The codebase UUID.
     * @param array $options Query parameters (limit, offset).
     */
    public function getBulkCodeSwitches(string $codebaseUuid, array $options = []): BulkCodeSwitchResponse
    {
        $path = "/codebases/$codebaseUuid/bulk-code-switch";

        if (!empty($options)) {
            $path .= '?' . http_build_query($options);
        }

        return new BulkCodeSwitchResponse(
            $this->client->request('get', $path)
        );
    }

    /**
     * Shows information about a specific bulk code switch.
     *
     * @param string $codebaseUuid The codebase UUID.
     * @param string $bulkCodeSwitchId The bulk code switch ID.
     */
    public function getBulkCodeSwitch(string $codebaseUuid, string $bulkCodeSwitchId): BulkCodeSwitchResponse
    {
        return new BulkCodeSwitchResponse(
            $this->client->request(
                'get',
                "/codebases/$codebaseUuid/bulk-code-switch/$bulkCodeSwitchId"
            )
        );
    }

    /**
     * Starts a new bulk code switch for a codebase.
     *
     * @param string $codebaseUuid The codebase UUID.
     * @param string $reference The reference to switch to (branch name or tag).
     * @param array $targets Array of targets with environment_id and optional cloud_actions.
     * @param array $cloudActions Optional global cloud actions to perform.
     */
    public function createBulkCodeSwitch(string $codebaseUuid, string $reference, array $targets, array $cloudActions = []): OperationResponse
    {
        $data = [
            'reference' => $reference,
            'targets' => $targets,
        ];

        if (!empty($cloudActions)) {
            $data['cloud_actions'] = $cloudActions;
        }

        return new OperationResponse(
            $this->client->request(
                'post',
                "/codebases/$codebaseUuid/bulk-code-switch",
                $data
            )
        );
    }
}
