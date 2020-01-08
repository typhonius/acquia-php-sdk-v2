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
        $body = $response->getBody();
        $object = json_decode($body);

        $request = new Request('PUT', '/applications/a47ac10b-58cc-4372-a567-0e02b2c3d471');
        $exception = new ApiErrorException($object);

        $client = $this
            ->getMockBuilder('AcquiaCloudApi\Connector\Client')
            ->disableOriginalConstructor()
            ->setMethods(['processResponse', 'makeRequest'])
            ->getMock();

        $client->method('processResponse')->willThrowException($exception);
        $this->expectException(ApiErrorException::class);
        $this->expectExceptionMessage('You do not have permission to modify this application.');

        $client->processResponse($response);
    }

    public function testError404()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Error/error404.json');
        $body = $response->getBody();
        $object = json_decode($body);

        $request = new Request('PUT', '/applications/a47ac10b-58cc-4372-a567-0e02b2c3d470');
        $exception = new ApiErrorException($object);

        $client = $this
            ->getMockBuilder('AcquiaCloudApi\Connector\Client')
            ->disableOriginalConstructor()
            ->setMethods(['processResponse', 'makeRequest'])
            ->getMock();

        $client->method('processResponse')->willThrowException($exception);
        $this->expectException(ApiErrorException::class);
        $this->expectExceptionMessage('The application with UUID a47ac10b-58cc-4372-a567-0e02b2c3d470 does not exist.');

        $client->processResponse($response);
    }

    public function testError503()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Error/error503.json');
        $body = $response->getBody();
        $object = json_decode($body);

        $request = new Request('PUT', '/applications/a47ac10b-58cc-4372-a567-0e02b2c3d470');
        $exception = new ApiErrorException($object);

        $client = $this
            ->getMockBuilder('AcquiaCloudApi\Connector\Client')
            ->disableOriginalConstructor()
            ->setMethods(['processResponse', 'makeRequest'])
            ->getMock();

        $client->method('processResponse')->willThrowException($exception);
        $this->expectException(ApiErrorException::class);
        $this->expectExceptionMessage('This action is currently unavailable. Please try again later.');

        $client->processResponse($response);
    }

    public function testMultipleErrors()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Error/multipleErrors.json');
        $body = $response->getBody();
        $object = json_decode($body);

        $request = new Request('PUT', '/applications/a47ac10b-58cc-4372-a567-0e02b2c3d470');
        $exception = new ApiErrorException($object);

        $client = $this
            ->getMockBuilder('AcquiaCloudApi\Connector\Client')
            ->disableOriginalConstructor()
            ->setMethods(['processResponse', 'makeRequest'])
            ->getMock();

        $client->method('processResponse')->willThrowException($exception);
        $this->expectException(ApiErrorException::class);
        $errorMessage = <<< EOM
The application you are trying to access does not exist, or you do not have permission to access it.
You do not have sufficient permissions to do this task.
EOM;
        $this->expectExceptionMessage($errorMessage);

        $client->processResponse($response);
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

        $request = new Request('GET', '/test');
        $exception = new ApiErrorException($object, 'Internal Server Error');

        $connector = $this
            ->getMockBuilder('AcquiaCloudApi\Connector\Connector')
            ->disableOriginalConstructor()
            ->setMethods(['processResponse'])
            ->getMock();

        $connector->method('processResponse')->willThrowException($exception);

        $exception = new ApiErrorException($object);
        $errorMessage = <<< EOM
AcquiaCloudApi\Exception\ApiErrorException: [forbidden]: You do not have permission to modify this application.\n
EOM;
        $this->assertEquals($exception->__toString(), $errorMessage);
    }
}
