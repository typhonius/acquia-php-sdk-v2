<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\MetricResponse;
use AcquiaCloudApi\Response\MetricsResponse;

/**
 * Class Metrics
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Metrics extends CloudApiBase
{
    /**
     * Retrieves aggregate usage data for an application.
     *
     *
     * @return MetricsResponse<MetricResponse>
     */
    public function getAggregateData(string $applicationUuid): MetricsResponse
    {
        return new MetricsResponse(
            $this->client->request(
                'get',
                "/applications/$applicationUuid/metrics/usage/data"
            )
        );
    }

    /**
     * Retrieves aggregate usage metric data for an application.
     *
     *
     */
    public function getAggregateUsageMetrics(string $applicationUuid, string $usageMetric): MetricResponse
    {
        return new MetricResponse(
            $this->client->request(
                'get',
                "/applications/$applicationUuid/metrics/usage/$usageMetric"
            )
        );
    }

    /**
     * Retrieves usage data for an application, broken down by environment.
     *
     *
     * @return MetricsResponse<MetricResponse>
     */
    public function getDataByEnvironment(string $applicationUuid): MetricsResponse
    {
        return new MetricsResponse(
            $this->client->request(
                'get',
                "/applications/$applicationUuid/metrics/usage/data-by-environment"
            )
        );
    }

    /**
     * Retrieves views data for an application, broken down by environment.
     *
     *
     * @return MetricsResponse<MetricResponse>
     */
    public function getViewsByEnvironment(string $applicationUuid): MetricsResponse
    {
        return new MetricsResponse(
            $this->client->request(
                'get',
                "/applications/$applicationUuid/metrics/usage/views-by-environment"
            )
        );
    }

    /**
     * Retrieves visits data for an application, broken down by environment.
     *
     *
     * @return MetricsResponse<MetricResponse>
     */
    public function getVisitsByEnvironment(string $applicationUuid): MetricsResponse
    {
        return new MetricsResponse(
            $this->client->request(
                'get',
                "/applications/$applicationUuid/metrics/usage/visits-by-environment"
            )
        );
    }

    /**
     * Returns StackMetrics data for the metrics specified in the filter
     * paramater
     * (e.g., apache-access, web-cpu).
     *
     *
     * @return MetricsResponse<MetricResponse>
     */
    public function getStackMetricsData(string $environmentUuid): MetricsResponse
    {
        return new MetricsResponse(
            $this->client->request(
                'get',
                "/environments/$environmentUuid/metrics/stackmetrics/data"
            )
        );
    }

    /**
     * Returns StackMetrics data for the metric (e.g., apache-access).
     *
     *
     */
    public function getStackMetricsDataByMetric(string $environmentUuid, string $metricType): MetricResponse
    {
        return new MetricResponse(
            $this->client->request(
                'get',
                "/environments/$environmentUuid/metrics/stackmetrics/$metricType"
            )
        );
    }
}
