<?php

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

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->applicationInsights('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\InsightsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\InsightResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }
}
