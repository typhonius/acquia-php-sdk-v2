<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use GuzzleHttp\Exception\BadResponseException;
use AcquiaCloudApi\Exception\ApiErrorException;
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
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Error/error403.json');
        $client = $this->getMockClient($response);
        $this->expectException(ApiErrorException::class);
        $this->expectExceptionMessage('You do not have permission to view applications.');

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $application = new Applications($client);
        $application->getAll();
    }

    public function testError404()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Error/error404.json');
        $client = $this->getMockClient($response);
        $this->expectException(ApiErrorException::class);
        $this->expectExceptionMessage(
            'The application you are trying to access does not exist, or you do not have permission to access it.'
        );
        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $application = new Applications($client);
        $application->getAll();
    }

    public function testMultipleErrors()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Error/multipleErrors.json');
        $client = $this->getMockClient($response);
        $this->expectException(ApiErrorException::class);
        $errorMessage = <<< EOM
The application you are trying to access does not exist, or you do not have permission to access it.
You do not have sufficient permissions to do this task.

EOM;
        $this->expectExceptionMessage($errorMessage);

        $application = new Applications($client);
        $application->getAll();
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

    public function testApiErrorException()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Error/error403.json');
        $body = $response->getBody();
        $object = json_decode($body);

        $exception = new ApiErrorException($object);
        $errorMessage = <<< EOM
AcquiaCloudApi\Exception\ApiErrorException: [forbidden]: You do not have permission to view applications.\n
EOM;
        $this->assertEquals($exception->__toString(), $errorMessage);
        $this->assertEquals($object, $exception->getResponseBody());
    }
}
