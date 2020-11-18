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
     * @param  string     $fixture The fixture to create the stream for.
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
     * @param  string        $fixture    The fixture to create the response for.
     * @param  integer       $statusCode A HTTP Status Code for the response.
     * @return Psr7\Response
     */
    protected function getPsr7JsonResponseForFixture($fixture, $statusCode = 200): Psr7\Response
    {
        $stream = $this->getPsr7StreamForFixture($fixture);
        $this->assertNotNull(json_decode($stream));
        $this->assertEquals(JSON_ERROR_NONE, json_last_error());

        // Spoof some of the headers that CloudAPI could respond with.
        // N.B. In reality, not all headers will appear on each request
        // e.g. X-CloudAPI-Notification-ID will only appear when a request generates a notification.
        $headers = [
            'Content-Type' => 'application/json',
            'X-CloudAPI-Notification-Id' => 'c936a375-4bb8-422d-9d05-a3ff352646f7',
            'X-CloudAPI-Stability' => 'production',
            'X-Request-Id' => 'v-2a996562-2945-11eb-8b05-22000b2996e0',
            'X-CloudAPI-Version' => '2',
            'X-AH-Environment' => 'prod',
        ];

        return new Psr7\Response($statusCode, $headers, $stream);
    }

    /**
     * Returns a PSR7 Response (Gzip) for a given fixture.
     *
     * @param  string        $fixture    The fixture to create the response for.
     * @param  integer       $statusCode A HTTP Status Code for the response.
     * @return Psr7\Response
     */
    protected function getPsr7GzipResponseForFixture($fixture, $statusCode = 200): Psr7\Response
    {
        $stream = $this->getPsr7StreamForFixture($fixture);
        $this->assertEquals(JSON_ERROR_NONE, json_last_error());

        return new Psr7\Response($statusCode, ['Content-Type' => 'application/octet-stream'], $stream);
    }

    /**
     * Mock client class.
     *
     * @param  mixed  $response
     * @return Client
     */
    protected function getMockClient($response = '')
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
}
