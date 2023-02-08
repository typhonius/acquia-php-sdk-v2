<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Insights;
use AcquiaCloudApi\Response\InsightModuleResponse;
use AcquiaCloudApi\Response\InsightAlertResponse;
use AcquiaCloudApi\Response\InsightCountResponse;
use AcquiaCloudApi\Response\InsightResponse;

class InsightsTest extends CloudApiTestCase
{
    public function testGetInsights(): void
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Insights/getAllInsights.json');
        $client = $this->getMockClient($response);

        $insights = new Insights($client);
        $result = $insights->getAll('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(InsightResponse::class, $record);
        }
    }

    public function testGetEnvironmentInsights(): void
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Insights/getEnvironment.json');
        $client = $this->getMockClient($response);

        $insights = new Insights($client);
        $result = $insights->getEnvironment('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(InsightResponse::class, $record);
        }
    }

    public function testGetInsight(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Insights/getInsight.json');
        $client = $this->getMockClient($response);

        $insights = new Insights($client);
        $result = $insights->get('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        // Check that insight counts consist of InsightCountResponse.
        $this->assertNotEmpty($result->counts);
        $this->assertIsObject($result->counts);
        $this->assertTrue(property_exists($result->counts, 'best_practices'));
        $this->assertTrue(property_exists($result->counts, 'security'));
        $this->assertTrue(property_exists($result->counts, 'performance'));
        foreach ((array)$result->counts as $response) {
            $this->assertInstanceOf(InsightCountResponse::class, $response);
        }
    }

    public function testGetAllAlerts(): void
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Insights/getAllAlerts.json');
        $client = $this->getMockClient($response);

        $insights = new Insights($client);
        $result = $insights->getAllAlerts('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(InsightAlertResponse::class, $record);
        }
    }

    public function testGetAlert(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Insights/getAlert.json');
        $client = $this->getMockClient($response);

        $insights = new Insights($client);
        $insights->getAlert(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            'da1c0a8e-ff69-45db-88fc-acd6d2affbb7'
        );
    }

    public function testIgnoreAlert(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Insights/ignoreAlert.json');
        $client = $this->getMockClient($response);

        $insights = new Insights($client);
        $result = $insights->ignoreAlert(
            '8ff6c046-ec64-4ce4-bea6-27845ec18600',
            'da1c0a8e-ff69-45db-88fc-acd6d2affbb7'
        );

        $this->assertEquals('Alert ignored.', $result->message);
    }

    public function testRestoreAlert(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Insights/restoreAlert.json');
        $client = $this->getMockClient($response);

        $insights = new Insights($client);
        $result = $insights->restoreAlert(
            '8ff6c046-ec64-4ce4-bea6-27845ec18600',
            'da1c0a8e-ff69-45db-88fc-acd6d2affbb7'
        );

        $this->assertEquals('Alert restored.', $result->message);
    }

    public function testRevokeSite(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Insights/revokeSite.json');
        $client = $this->getMockClient($response);

        $insights = new Insights($client);
        $result = $insights->revoke('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertEquals('Site revoked from submitting Insight score data.', $result->message);
    }

    public function testUnrevokeSite(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Insights/unrevokeSite.json');
        $client = $this->getMockClient($response);

        $insights = new Insights($client);
        $result = $insights->unrevoke('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertEquals('Site un-revoked.', $result->message);
    }

    public function testGetModules(): void
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Insights/getModules.json');
        $client = $this->getMockClient($response);

        $insights = new Insights($client);
        $result = $insights->getModules('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(InsightModuleResponse::class, $record);
        }
    }
}
