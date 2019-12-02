<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use AcquiaCloudApi\Endpoints\Applications;
use AcquiaCloudApi\Connector\Client;
use AcquiaCloudApi\Connector\Connector;

class ErrorTest extends CloudApiTestCase
{

    public function testError403()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/error403.json');

        $client = $this->getMockClient($response);

        try {
            /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
            $application = new Applications($client);
            $application->getApplications();
        } catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), 'You do not have permission to view applications.');

            return;
        }

        $this->fail();
    }

    public function testError404()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/error404.json');

        $client = $this->getMockClient($response);

        try {
            /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
            $application = new Applications($client);
            $application->getApplications();
        } catch (\Exception $e) {
            $this->assertEquals(
                $e->getMessage(),
                'The application you are trying to access does not exist, or you do not have permission to access it.'
            );

            return;
        }

        $this->fail();
    }

    public function testMultipleErrors()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/multipleErrors.json');
        $client = $this->getMockClient($response);

        try {
            /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
            $application = new Applications($client);
            $application->getApplications();
        } catch (\Exception $e) {
            $error = <<< EOM
The application you are trying to access does not exist, or you do not have permission to access it.
You do not have sufficient permissions to do this task.

EOM;

            $this->assertEquals($e->getMessage(), $error);

            return;
        }

        $this->fail();
    }

    public function testErrorException()
    {

        $request = new Request('GET', '/test');
        $response = new Response(500);
        $exception = new BadResponseException('Internal Server Error', $request, $response);

        $connector = $this
            ->getMockBuilder('AcquiaCloudApi\Connector\Connector')
            ->disableOriginalConstructor()
            ->setMethods(['sendRequest'])
            ->getMock();
        
        $connector->method('sendRequest')->willThrowException($exception);
        $client = Client::factory($connector);
        $response = $client->makeRequest('GET', '/test');

        $this->assertEquals($response->getStatusCode(), 500);
        $this->assertEquals($response->getReasonPhrase(), 'Internal Server Error');
    }
}
