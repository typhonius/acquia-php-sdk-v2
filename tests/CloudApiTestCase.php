<?php

namespace AcquiaCloudApi\Tests;

use AcquiaCloudApi\Connector\Client;
use GuzzleHttp\Psr7;
use PHPUnit\Framework\TestCase;

/**
 * Class CloudApiTestCase
 */
abstract class CloudApiTestCase extends TestCase
{

    /**
     * Returns a PSR7 Stream for a given fixture.
     *
     * @param  string $fixture The fixture to create the stream for.
     * @return Psr7\Stream
     */
    protected function getPsr7StreamForFixture($fixture): Psr7\Stream
    {
        $path = sprintf('%s/Fixtures/%s', __DIR__, $fixture);
        $this->assertFileExists($path);
        $stream = Psr7\stream_for(file_get_contents($path));
        $this->assertInstanceOf(Psr7\Stream::class, $stream);

        return $stream;
    }

    /**
     * Returns a PSR7 Response (JSON) for a given fixture.
     *
     * @param  string  $fixture    The fixture to create the response for.
     * @param  integer $statusCode A HTTP Status Code for the response.
     * @return Psr7\Response
     */
    protected function getPsr7JsonResponseForFixture($fixture, $statusCode = 200): Psr7\Response
    {
        $stream = $this->getPsr7StreamForFixture($fixture);
        $this->assertNotNull(json_decode($stream));
        $this->assertEquals(JSON_ERROR_NONE, json_last_error());

        return new Psr7\Response($statusCode, ['Content-Type' => 'application/json'], $stream);
    }

    /**
     * Returns a PSR7 Response (Gzip) for a given fixture.
     *
     * @param  string  $fixture    The fixture to create the response for.
     * @param  integer $statusCode A HTTP Status Code for the response.
     * @return Psr7\Response
     */
    protected function getPsr7GzipResponseForFixture($fixture, $statusCode = 200): Psr7\Response
    {
        $stream = $this->getPsr7StreamForFixture($fixture);

        return new Psr7\Response($statusCode, ['Content-Type' => 'application/octet-stream'], $stream);
    }

    /**
     * Mock client class.
     *
     * @param  mixed $response
     * @return Client
     */
    protected function getMockClient($response = ''): Client
    {
        if ($response) {
            $connector = $this
                ->getMockBuilder('AcquiaCloudApi\Connector\Connector')
                ->disableOriginalConstructor()
                ->setMethods(['sendRequest'])
                ->getMock();

            $connector
                ->expects($this->atLeastOnce())
                ->method('sendRequest')
                ->willReturn($response);
        } else {
            $connector = $this
                ->getMockBuilder('AcquiaCloudApi\Connector\Connector')
                ->disableOriginalConstructor()
                ->getMock();
        }

        $client = Client::factory($connector);

        return $client;
    }

    /**
     * Uses reflection to retrieve the internal request options to test passed parameters.
     *
     * @param  Client $client
     * @return array
     */
    protected function getRequestOptions($client): array
    {
        $reflectionClass = new \ReflectionClass('AcquiaCloudApi\Connector\Client');
        $property = $reflectionClass->getProperty('requestOptions');
        $property->setAccessible(true);
        return $property->getValue($client);
    }
}
