<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\InsightsResponse;
use AcquiaCloudApi\Response\InsightResponse;
use AcquiaCloudApi\Response\InsightAlertsResponse;
use AcquiaCloudApi\Response\InsightAlertResponse;
use AcquiaCloudApi\Response\InsightModulesResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Insights
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Insights extends CloudApiBase implements CloudApiInterface
{

    /**
     * Returns Insight data for all sites associated with the application by its UUID.
     *
     * @param  string $applicationUuid
     * @return InsightsResponse
     */
    public function getAll($applicationUuid)
    {
        return new InsightsResponse(
            $this->client->request(
                'get',
                "/applications/${applicationUuid}/insight"
            )
        );
    }

    /**
     * Returns Insight data for all sites associated with the environment by its UUID.
     *
     * @param  string $environmentUuid
     * @return InsightsResponse
     */
    public function getEnvironment($environmentUuid)
    {
        return new InsightsResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/insight"
            )
        );
    }

    /**
     * Returns insight data for a particular site.
     *
     * @param  string $siteId
     * @return InsightResponse
     */
    public function get($siteId)
    {
        return new InsightResponse(
            $this->client->request(
                'get',
                "/insight/${siteId}"
            )
        );
    }

    /**
     * Returns a list of Insight alerts for this site.
     *
     * @param  string $siteId
     * @return InsightAlertsResponse
     */
    public function getAllAlerts($siteId)
    {
        return new InsightAlertsResponse(
            $this->client->request(
                'get',
                "/insight/${siteId}/alerts"
            )
        );
    }

    /**
     * Returns a specific Insight alert for this site.
     *
     * @param  string $siteId
     * @param  string $alertUuid
     * @return InsightAlertResponse
     */
    public function getAlert($siteId, $alertUuid)
    {
        return new InsightAlertResponse(
            $this->client->request(
                'get',
                "/insight/${siteId}/alerts/${alertUuid}"
            )
        );
    }

    /**
     * Ignores an alert. An ignored alert will be included will not be counted in the Insight score calculation.
     *
     * @param  string $siteId
     * @param  string $alertUuid
     * @return OperationResponse
     */
    public function ignoreAlert($siteId, $alertUuid)
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/insight/${siteId}/alerts/${alertUuid}/actions/ignore"
            )
        );
    }

    /**
     * Restores an alert. A restored alert will be included in the calculation of the Insight score.
     *
     * @param  string $siteId
     * @param  string $alertUuid
     * @return OperationResponse
     */
    public function restoreAlert($siteId, $alertUuid)
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/insight/${siteId}/alerts/${alertUuid}/actions/restore"
            )
        );
    }

    /**
     * Revokes an Insight install so it can no longer submit data using the Acquia Connector module.
     *
     * @param  string $siteId
     * @return OperationResponse
     */
    public function revoke($siteId)
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/insight/${siteId}/actions/revoke"
            )
        );
    }

    /**
     * Un-revokes an Insight site so it can once again submit data using the Acquia Connector module.
     * Note that the site must also be unblocked using the Acquia Connector module.
     *
     * @param  string $siteId
     * @return OperationResponse
     */
    public function unrevoke($siteId)
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/insight/${siteId}/actions/unrevoke"
            )
        );
    }

    /**
     * Returns a list of Drupal modules for this site.
     *
     * @param  string $siteId
     * @return InsightModulesResponse
     */
    public function getModules($siteId)
    {
        return new InsightModulesResponse(
            $this->client->request(
                'get',
                "/insight/${siteId}/modules"
            )
        );
    }
}
