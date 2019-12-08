<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Insights;

class InsightsTest extends CloudApiTestCase
{

    public $properties = [
    'label',
    'hostname',
    'status',
    'scores',
    'counts',
    'flags',
    'links'
    ];

    public function testGetInsights()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getInsights.json');
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

    public function testGetInsight()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getInsight.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $insights = new Insights($client);
        $result = $insights->get('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\InsightResponse', $result);
        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }
}
