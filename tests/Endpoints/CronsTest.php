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

    // delete cron
    // delete domain

    public function testGetCrons()
    {

        $response = $this->generateCloudApiResponse('Endpoints/getCrons.json');
        $crons = new \AcquiaCloudApi\Response\CronsResponse($response);


        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['crons'])
        ->getMock();
        $client->expects($this->once())
        ->method('crons')
        ->with('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851')
        ->will($this->returnValue($crons));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->crons('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\CronsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\CronResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testCronAdd()
    {
        $response = $this->generateCloudApiResponse('Endpoints/addCron.json');

        $message = new \AcquiaCloudApi\Response\OperationResponse($response);

        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['createCron'])
        ->getMock();

        $client->expects($this->once())
        ->method('createCron')
        ->with('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', '/usr/local/bin/drush cc all', '*/30 * * * *', 'My New Cron')
        ->will($this->returnValue($message));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->createCron(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            '/usr/local/bin/drush cc all',
            '*/30 * * * *',
            'My New Cron'
        );
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Creating a new cron.', $result->message);
    }

    public function testCronDelete()
    {
        $response = $this->generateCloudApiResponse('Endpoints/deleteCron.json');

        $message = new \AcquiaCloudApi\Response\OperationResponse($response);

        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['deleteCron'])
        ->getMock();

        $client->expects($this->once())
        ->method('deleteCron')
        ->with('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 14)
        ->will($this->returnValue($message));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->deleteCron('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 14);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Deleting cron.', $result->message);
    }
}
