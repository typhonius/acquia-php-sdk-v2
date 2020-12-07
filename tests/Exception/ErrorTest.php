<?php

namespace AcquiaCloudApi\Tests\Exception;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use GuzzleHttp\Exception\BadResponseException;
use AcquiaCloudApi\Exception\ApiErrorException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use AcquiaCloudApi\Endpoints\Applications;
use AcquiaCloudApi\Connector\Client;
use AcquiaCloudApi\Connector\Connector;
use AcquiaCloudApi\Response\ApplicationsResponse;

class ErrorTest extends CloudApiTestCase
{

    public function testError403(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Error/error403.json');
        $client = $this->getMockClient($response);
        $this->expectException(ApiErrorException::class);
        $this->expectExceptionMessage('You do not have permission to view applications.');

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $application = new Applications($client);
        $application->getAll();
    }

    public function testError404(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Error/error404.json');
        $client = $this->getMockClient($response);
        $this->expectException(ApiErrorException::class);
        $this->expectExceptionMessage(
            'The application you are trying to access does not exist, or you do not have permission to access it.'
        );
        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $application = new Applications($client);
        $application->getAll();
    }

    public function testMultipleErrors(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Error/multipleErrors.json');
        $client = $this->getMockClient($response);
        $this->expectException(ApiErrorException::class);
        $errorMessage = <<< EOM
The application you are trying to access does not exist, or you do not have permission to access it.
You do not have sufficient permissions to do this task.

EOM;
        $this->expectExceptionMessage($errorMessage);
        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $application = new Applications($client);
        $application->getAll();
    }

    public function testErrorException(): void
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

    public function testApiErrorException(): void
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
        $this->assertEquals(0, $exception->getCode());

        $exception = new ApiErrorException($object, "", 403);
        $errorMessage = <<< EOM
AcquiaCloudApi\Exception\ApiErrorException: [forbidden]: You do not have permission to view applications.\n
EOM;
        $this->assertEquals($exception->__toString(), $errorMessage);
        $this->assertEquals($object, $exception->getResponseBody());
        $this->assertEquals(403, $exception->getCode());
    }

    public function testCollectionException(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('CollectionResponse does not contain embedded items.');

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Applications/getAllApplications.json');
        $body_json = $response->getBody();
        $body = json_decode($body_json);
        unset($body->_embedded);

        new ApplicationsResponse($body);
    }
}
