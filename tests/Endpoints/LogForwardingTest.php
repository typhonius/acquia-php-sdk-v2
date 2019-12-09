<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\LogForwardingDestinations;

class LogForwardingTest extends CloudApiTestCase
{

    public $properties = [
    'uuid',
    'label',
    'address',
    'consumer',
    'credentials',
    'sources',
    'status',
    'flags',
    'health',
    'environment'
    ];

    public function testGetLogForwardingDestinations()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/LogForwarding/getAllLogForwarding.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $logForwarding = new LogForwardingDestinations($client);
        $result = $logForwarding->getAll('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\LogForwardingDestinationsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\LogForwardingDestinationResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetLogForwardingDestination()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/LogForwarding/getLogForwarding.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $logForwarding = new LogForwardingDestinations($client);
        $result = $logForwarding->get('8ff6c046-ec64-4ce4-bea6-27845ec18600', 3);

        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\LogForwardingDestinationsResponse', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\LogForwardingDestinationResponse', $result);

        foreach ($this->properties as $property) {
              $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testCreateLogForwardingDestination()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/LogForwarding/createLogForwarding.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $logForwarding = new LogForwardingDestinations($client);

        $result = $logForwarding->create(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            'Test destination',
            ["apache-access", "apache-error"],
            'syslog',
            ["certificate" => "-----BEGIN CERTIFICATE-----...-----END CERTIFICATE-----"],
            'example.com:1234'
        );

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Log forwarding destination for the environment has been created.', $result->message);
    }

    public function testDeleteLogForwardingDestination()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/LogForwarding/deleteLogForwarding.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $logForwarding = new LogForwardingDestinations($client);
        $result = $logForwarding->delete('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 14);

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Log forwarding destination has been deleted.', $result->message);
    }

    public function testEnableLogForwardingDestination()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/LogForwarding/enableLogForwarding.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $logForwarding = new LogForwardingDestinations($client);
        $result = $logForwarding->enable('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 2);

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Log forwarding destination has been enabled.', $result->message);
    }

    public function testDisableLogForwardingDestination()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/LogForwarding/disableLogForwarding.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $logForwarding = new LogForwardingDestinations($client);
        $result = $logForwarding->disable('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 2);

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Log forwarding destination has been disabled.', $result->message);
    }

    public function testUpdateLogForwardingDestination()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/LogForwarding/updateLogForwarding.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $logForwarding = new LogForwardingDestinations($client);
        $result = $logForwarding->update(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            12,
            'Test destination',
            ["apache-access", "apache-error"],
            'syslog',
            ["certificate" => "-----BEGIN CERTIFICATE-----...-----END CERTIFICATE-----"],
            'example.com:1234'
        );

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Log forwarding destination has been updated.', $result->message);
    }
}
