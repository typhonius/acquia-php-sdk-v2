<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Crons;

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

    public function testGetAllCrons()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getCrons.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $environment = new Crons($client);
        $result = $environment->getAll('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\CronsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\CronResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetCron()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getCron.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $environment = new Crons($client);
        $result = $environment->get('8ff6c046-ec64-4ce4-bea6-27845ec18600', 3);

        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\CronsResponse', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\CronResponse', $result);

        foreach ($this->properties as $property) {
              $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testCreateCron()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/createCron.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $environment = new Crons($client);
        $result = $environment->create(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            '/usr/local/bin/drush cc all',
            '*/30 * * * *',
            'My New Cron'
        );

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Creating a new cron.', $result->message);
    }

    public function testUpdateCron()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateCron.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $cron = new Crons($client);
        $result = $cron->update(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            14,
            '/usr/local/bin/drush cc all',
            '*/30 * * * *',
            'My New Cron'
        );

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Updating cron.', $result->message);
    }

    public function testDeleteCron()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/deleteCron.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $environment = new Crons($client);
        $result = $environment->delete('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 14);

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Deleting cron.', $result->message);
    }

    public function testEnableCron()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/enableCron.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $environment = new Crons($client);
        $result = $environment->enable('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 2);

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('The cron is being enabled.', $result->message);
    }

    public function testDisableCron()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/disableCron.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $environment = new Crons($client);
        $result = $environment->disable('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 2);

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('The cron is being disabled.', $result->message);
    }
}
