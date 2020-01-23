<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Insights;

class InsightsTest extends CloudApiTestCase
{

    public $properties = [
    'uuid',
    'label',
    'hostname',
    'status',
    'updatedAt',
    'lastConnectedAt',
    'scores',
    'counts',
    'flags',
    'links'
    ];

    public $alertProperties = [
        'alert_id',
        'uuid',
        'name',
        'message',
        'article_link',
        'severity',
        'severity_label',
        'failed_value',
        'fix_details',
        'categories',
        'flags',
        'links'
    ];

    public $moduleProperties = [
        'module_id',
        'name',
        'filename',
        'version',
        'supported_majors',
        'recommended_major',
        'package',
        'core',
        'project',
        'release_date',
        'flags',
        'tags'
    ];

    public function testGetInsights()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Insights/getAllInsights.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $insights = new Insights($client);
        $result = $insights->getAll('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\InsightsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\InsightResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetEnvironmentInsights()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Insights/getEnvironment.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $insights = new Insights($client);
        $result = $insights->getEnvironment('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\InsightsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\InsightResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetInsight()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Insights/getInsight.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $insights = new Insights($client);
        $result = $insights->get('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\InsightResponse', $result);
        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testGetAllAlerts()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Insights/getAllAlerts.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $insights = new Insights($client);
        $result = $insights->getAllAlerts('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\InsightAlertsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\InsightAlertResponse', $record);

            foreach ($this->alertProperties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetAlert()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Insights/getAlert.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $insights = new Insights($client);
        $result = $insights->getAlert(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            'da1c0a8e-ff69-45db-88fc-acd6d2affbb7'
        );

        $this->assertInstanceOf('\AcquiaCloudApi\Response\InsightAlertResponse', $result);
        foreach ($this->alertProperties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testIgnoreAlert()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Insights/ignoreAlert.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $insights = new Insights($client);
        $result = $insights->ignoreAlert(
            '8ff6c046-ec64-4ce4-bea6-27845ec18600',
            'da1c0a8e-ff69-45db-88fc-acd6d2affbb7'
        );

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Alert ignored.', $result->message);
    }

    public function testRestoreAlert()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Insights/restoreAlert.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $insights = new Insights($client);
        $result = $insights->restoreAlert(
            '8ff6c046-ec64-4ce4-bea6-27845ec18600',
            'da1c0a8e-ff69-45db-88fc-acd6d2affbb7'
        );

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Alert restored.', $result->message);
    }

    public function testRevokeSite()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Insights/revokeSite.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $insights = new Insights($client);
        $result = $insights->revoke('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Site revoked from submitting Insight score data.', $result->message);
    }

    public function testUnrevokeSite()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Insights/unrevokeSite.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $insights = new Insights($client);
        $result = $insights->unrevoke('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Site un-revoked.', $result->message);
    }

    public function testGetModules()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Insights/getModules.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $insights = new Insights($client);
        $result = $insights->getModules('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\InsightModulesResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\InsightModuleResponse', $record);

            foreach ($this->moduleProperties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }
}
