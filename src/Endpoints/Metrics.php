<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\MetricsResponse;
use AcquiaCloudApi\Response\MetricResponse;

/**
 * Class Metrics
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Metrics extends CloudApiBase implements CloudApiInterface
{

    /**
     * Retrieves aggregate usage data for an application.
     *
     * @return MetricsResponse
     * @param  string $applicationUuid
     */
    public function getAggregateData($applicationUuid)
    {
        return new MetricsResponse(
            $this->client->request(
                'get',
                "/applications/${applicationUuid}/metrics/usage/data"
            )
        );
    }

    /**
     * Retrieves aggregate usage metric data for an application.
     *
     * @return MetricResponse
     * @param  string $applicationUuid
     * @param  string $usageMetric
     */
    public function getAggregateUsageMetrics($applicationUuid, $usageMetric)
    {
        return new MetricResponse(
            $this->client->request(
                'get',
                "/applications/${applicationUuid}/metrics/usage/${usageMetric}"
            )
        );
    }

    /**
     * Retrieves usage data for an application, broken down by environment.
     *
     * @return MetricsResponse
     * @param  string $applicationUuid
     */
    public function getDataByEnvironment($applicationUuid)
    {
        return new MetricsResponse(
            $this->client->request(
                'get',
                "/applications/${applicationUuid}/metrics/usage/data-by-environment"
            )
        );
    }

    /**
     * Retrieves views data for an application, broken down by environment.
     *
     * @return MetricsResponse
     * @param  string $applicationUuid
     */
    public function getViewsByEnvironment($applicationUuid)
    {
        return new MetricsResponse(
            $this->client->request(
                'get',
                "/applications/${applicationUuid}/metrics/usage/views-by-environment"
            )
        );
    }

    /**
     * Retrieves visits data for an application, broken down by environment.
     *
     * @return MetricsResponse
     * @param  string $applicationUuid
     */
    public function getVisitsByEnvironment($applicationUuid)
    {
        return new MetricsResponse(
            $this->client->request(
                'get',
                "/applications/${applicationUuid}/metrics/usage/visits-by-environment"
            )
        );
    }

    /**
     * Returns StackMetrics data for the metrics specified in the filter paramater
     * (e.g., apache-access, web-cpu).
     *
     * @return MetricsResponse
     * @param  string $environmentUuid
     */
    public function getStackMetricsData($environmentUuid)
    {
        return new MetricsResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/metrics/stackmetrics/data"
            )
        );
    }

    /**
     * Returns StackMetrics data for the metric (e.g., apache-access).
     *
     * @return MetricResponse
     * @param  string $environmentUuid
     * @param  string $metricType
     */
    public function getStackMetricsDataByMetric($environmentUuid, $metricType)
    {
        return new MetricResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/metrics/stackmetrics/${metricType}"
            )
        );
    }
}
