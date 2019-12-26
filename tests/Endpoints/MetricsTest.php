<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Metrics;

class MetricsTest extends CloudApiTestCase
{

    protected $properties = [
    'metric',
    'datapoints',
    'last_data_at',
    'metadata',
    'links'
    ];

    public function testGetAggregateData()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Metrics/getAggregateData.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $account = new Metrics($client);
        $result = $account->getAggregateData('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\MetricsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\MetricResponse', $record);
            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetAggregateUsageMetrics()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Metrics/getAggregateUsageMetrics.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $account = new Metrics($client);
        $result = $account->getAggregateUsageMetrics('8ff6c046-ec64-4ce4-bea6-27845ec18600', 'views');

        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\MetricsResponse', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\MetricResponse', $result);
        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }
    public function testGetDataByEnvironment()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Metrics/getDataByEnvironment.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $account = new Metrics($client);
        $result = $account->getDataByEnvironment('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\MetricsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\MetricResponse', $record);
            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }
    public function testGetViewsByEnvironment()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Metrics/getViewsByEnvironment.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $account = new Metrics($client);
        $result = $account->getViewsByEnvironment('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\MetricsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\MetricResponse', $record);
            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }
    public function testGetVisitsByEnvironment()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Metrics/getVisitsByEnvironment.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $account = new Metrics($client);
        $result = $account->getVisitsByEnvironment('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\MetricsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\MetricResponse', $record);
            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }
    public function testGetStackMetricsData()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Metrics/getStackMetricsData.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $account = new Metrics($client);
        $result = $account->getStackMetricsData('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\MetricsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\MetricResponse', $record);
            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }
    public function testGetStackMetricsDataByMetric()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Metrics/getStackMetricsDataByMetric.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $account = new Metrics($client);
        $result = $account->getStackMetricsDataByMetric('8ff6c046-ec64-4ce4-bea6-27845ec18600', 'web-cpu');

        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\MetricsResponse', $result);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }
}
