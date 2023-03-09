<?php

namespace AcquiaCloudApi\Tests;

use AcquiaCloudApi\Connector\Client;
use AcquiaCloudApi\Connector\ClientInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Psr7\Utils;
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
     */
    protected function getPsr7StreamForFixture(string $fixture): Stream
    {
        $path = sprintf('%s/Fixtures/%s', __DIR__, $fixture);
        $this->assertFileExists($path);
        $stream = Utils::streamFor(file_get_contents($path));
        $this->assertInstanceOf(Stream::class, $stream);

        return $stream;
    }

    /**
     * Returns a PSR7 Response (JSON) for a given fixture.
     *
     * @param  string  $fixture    The fixture to create the response for.
     * @param  integer $statusCode A HTTP Status Code for the response.
     */
    protected function getPsr7JsonResponseForFixture(string $fixture, int $statusCode = 200): Response
    {
        $stream = $this->getPsr7StreamForFixture($fixture);
        $this->assertNotNull(json_decode($stream));
        $this->assertEquals(JSON_ERROR_NONE, json_last_error());

        return new Response($statusCode, ['Content-Type' => 'application/json'], $stream);
    }

    /**
     * Returns a PSR7 Response (Gzip) for a given fixture.
     *
     * @param  string  $fixture    The fixture to create the response for.
     * @param  integer $statusCode A HTTP Status Code for the response.
     */
    protected function getPsr7GzipResponseForFixture(string $fixture, int $statusCode = 200): Response
    {
        $stream = $this->getPsr7StreamForFixture($fixture);

        return new Response($statusCode, ['Content-Type' => 'application/octet-stream'], $stream);
    }

    /**
     * Mock client class.
     *
     */
    protected function getMockClient(mixed $response = ''): ClientInterface
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
     * @return array<mixed>
     */
    protected function getRequestOptions(ClientInterface $client): array
    {
        $reflectionClass = new \ReflectionClass('AcquiaCloudApi\Connector\Client');
        $property = $reflectionClass->getProperty('requestOptions');
        $property->setAccessible(true);
        return $property->getValue($client);
    }
}
