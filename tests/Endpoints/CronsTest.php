<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Crons;
use AcquiaCloudApi\Response\CronResponse;
use AcquiaCloudApi\Response\CronsResponse;

class CronsTest extends CloudApiTestCase
{
    public function testGetAllCrons(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Crons/getAllCrons.json');
        $client = $this->getMockClient($response);

        $cron = new Crons($client);
        $result = $cron->getAll('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(CronResponse::class, $record);
        }
    }

    public function testGetCron(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Crons/getCron.json');
        $client = $this->getMockClient($response);

        $cron = new Crons($client);
        $result = $cron->get('8ff6c046-ec64-4ce4-bea6-27845ec18600', 3);

        $this->assertNotInstanceOf(CronsResponse::class, $result);
    }

    public function testCreateCron(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Crons/createCron.json');
        $client = $this->getMockClient($response);

        $cron = new Crons($client);
        $result = $cron->create(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            '/usr/local/bin/drush cc all',
            '*/30 * * * *',
            'My New Cron'
        );

        $requestOptions = [
            'json' => [
                'command' => '/usr/local/bin/drush cc all',
                'frequency' => '*/30 * * * *',
                'label' => 'My New Cron',
                'server_id' => null
            ],
        ];

        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals('Creating a new cron.', $result->message);
    }

    public function testUpdateCron(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Crons/updateCron.json');
        $client = $this->getMockClient($response);

        $cron = new Crons($client);
        $result = $cron->update(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            '14',
            '/usr/local/bin/drush cc all',
            '*/30 * * * *',
            'My New Cron',
            '18'
        );

        $requestOptions = [
            'json' => [
                'command' => '/usr/local/bin/drush cc all',
                'frequency' => '*/30 * * * *',
                'label' => 'My New Cron',
                'server_id' => '18'
            ],
        ];

        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals('Updating cron.', $result->message);
    }

    public function testUpdateCronNoServerId(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Crons/updateCron.json');
        $client = $this->getMockClient($response);

        $cron = new Crons($client);
        $result = $cron->update(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            '14',
            '/usr/local/bin/drush cc all',
            '*/30 * * * *',
            'My New Cron'
        );

        $requestOptions = [
            'json' => [
                'command' => '/usr/local/bin/drush cc all',
                'frequency' => '*/30 * * * *',
                'label' => 'My New Cron',
            ],
        ];

        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals('Updating cron.', $result->message);
    }

    public function testDeleteCron(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Crons/deleteCron.json');
        $client = $this->getMockClient($response);

        $cron = new Crons($client);
        $result = $cron->delete('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 14);

        $this->assertEquals('Deleting cron.', $result->message);
    }

    public function testEnableCron(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Crons/enableCron.json');
        $client = $this->getMockClient($response);

        $cron = new Crons($client);
        $result = $cron->enable('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 2);

        $this->assertEquals('The cron is being enabled.', $result->message);
    }

    public function testDisableCron(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Crons/disableCron.json');
        $client = $this->getMockClient($response);

        $cron = new Crons($client);
        $result = $cron->disable('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 2);

        $this->assertEquals('The cron is being disabled.', $result->message);
    }
}
