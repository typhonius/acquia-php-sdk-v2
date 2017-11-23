<?php

class CronsTest extends CloudApiTestCase
{

    public $properties = [
    'id',
    'server',
    'command',
    'minute',
    'hour',
    'dayMonth',
    'month',
    'dayWeek',
    'label',
    'flags',
    'environment',
    'links'
    ];

    public function testGetCrons()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getCrons.json');
        $client = $this->getMockClient($response);

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->crons('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\CronsResponse', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\CronResponse', $result);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testCronAdd()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/addCron.json');
        $client = $this->getMockClient($response);

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->createCron('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', '/usr/local/bin/drush cc all', '*/30 * * * *', 'My New Cron');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Creating a new cron.', $result->message);
    }

    public function testCronDelete()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/deleteCron.json');
        $client = $this->getMockClient($response);

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->deleteCron('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 14);

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Deleting cron.', $result->message);
    }
}
