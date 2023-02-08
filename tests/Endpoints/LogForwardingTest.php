<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\LogForwardingDestinations;
use AcquiaCloudApi\Response\LogForwardingDestinationsResponse;
use AcquiaCloudApi\Response\LogForwardingDestinationResponse;

class LogForwardingTest extends CloudApiTestCase
{
    public function testGetLogForwardingDestinations(): void
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/LogForwarding/getAllLogForwarding.json');
        $client = $this->getMockClient($response);

        $logForwarding = new LogForwardingDestinations($client);
        $result = $logForwarding->getAll('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(LogForwardingDestinationResponse::class, $record);
        }
    }

    public function testGetLogForwardingDestination(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/LogForwarding/getLogForwarding.json');
        $client = $this->getMockClient($response);

        $logForwarding = new LogForwardingDestinations($client);
        $result = $logForwarding->get('8ff6c046-ec64-4ce4-bea6-27845ec18600', 3);

        $this->assertNotInstanceOf(LogForwardingDestinationsResponse::class, $result);
    }

    public function testCreateLogForwardingDestination(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/LogForwarding/createLogForwarding.json');
        $client = $this->getMockClient($response);

        $logForwarding = new LogForwardingDestinations($client);

        $result = $logForwarding->create(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            'Test destination',
            ["apache-access", "apache-error"],
            'syslog',
            ["certificate" => "-----BEGIN CERTIFICATE-----...-----END CERTIFICATE-----"],
            'example.com:1234'
        );

        $requestOptions = [
            'json' => [
                'label' => 'Test destination',
                'sources' => ["apache-access", "apache-error"],
                'consumer' => 'syslog',
                'credentials' => ["certificate" => "-----BEGIN CERTIFICATE-----...-----END CERTIFICATE-----"],
                'address' => 'example.com:1234'
            ],
        ];
        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals('Log forwarding destination for the environment has been created.', $result->message);
    }

    public function testDeleteLogForwardingDestination(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/LogForwarding/deleteLogForwarding.json');
        $client = $this->getMockClient($response);

        $logForwarding = new LogForwardingDestinations($client);
        $result = $logForwarding->delete('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 14);

        $this->assertEquals('Log forwarding destination has been deleted.', $result->message);
    }

    public function testEnableLogForwardingDestination(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/LogForwarding/enableLogForwarding.json');
        $client = $this->getMockClient($response);

        $logForwarding = new LogForwardingDestinations($client);
        $result = $logForwarding->enable('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 2);

        $this->assertEquals('Log forwarding destination has been enabled.', $result->message);
    }

    public function testDisableLogForwardingDestination(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/LogForwarding/disableLogForwarding.json');
        $client = $this->getMockClient($response);

        $logForwarding = new LogForwardingDestinations($client);
        $result = $logForwarding->disable('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 2);

        $this->assertEquals('Log forwarding destination has been disabled.', $result->message);
    }

    public function testUpdateLogForwardingDestination(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/LogForwarding/updateLogForwarding.json');
        $client = $this->getMockClient($response);

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

        $requestOptions = [
            'json' => [
                'label' => 'Test destination',
                'sources' => ["apache-access", "apache-error"],
                'consumer' => 'syslog',
                'credentials' => ["certificate" => "-----BEGIN CERTIFICATE-----...-----END CERTIFICATE-----"],
                'address' => 'example.com:1234'
            ],
        ];
        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals('Log forwarding destination has been updated.', $result->message);
    }
}
