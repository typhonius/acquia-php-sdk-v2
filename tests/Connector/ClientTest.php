<?php

namespace AcquiaCloudApi\Tests\Connector;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Connector\Client;
use AcquiaCloudApi\Connector\Connector;
use AcquiaCloudApi\Endpoints\Code;
use AcquiaCloudApi\Exception\NonJsonResponseException;
use GuzzleHttp\Psr7\Response;
use JsonException;

class ClientTest extends CloudApiTestCase
{
    public function testAddQuery(): void
    {
        $client = $this->getMockClient();

        $client->addQuery('filter', 'name=dev');
        $client->addQuery('filter', 'type=file');

        $expectedQuery = [
            'filter' => [
                'name=dev',
                'type=file',
            ],
        ];

        $this->assertEquals($expectedQuery, $client->getQuery());
    }

    public function testFilteredQuery(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Client/getFilteredCode.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $client->addQuery('filter', 'name=@*2014*');
        $client->addQuery('filter', 'type=@*true*');
        $code = new Code($client);
        $result = $code->getAll('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        foreach ($result as $record) {
            $this->assertStringContainsString('2014', $record->name);
        }
    }

    /**
     * @dataProvider providerNonJsonResponse
     * @param array<string, string> $headers
     */
    public function testNonJsonResponse(int $status, array $headers, string $body, string $expectedMessage): void
    {
        $response = new Response($status, $headers, $body);
        $client = $this->getMockClient($response);

        $code = new Code($client);
        try {
            $code->getAll('8ff6c046-ec64-4ce4-bea6-27845ec18600');
            $this->fail('Expected a NonJsonResponseException');
        } catch (NonJsonResponseException $e) {
            $this->assertSame($expectedMessage, $e->getMessage());
            $this->assertSame($response, $e->getResponse());
            $this->assertInstanceOf(JsonException::class, $e->getPrevious());
        }
    }

    /**
     * @return array<string, array{int, array<string, string>, string, string}>
     */
    public static function providerNonJsonResponse(): array
    {
        $prefix = 'Cloud API returned a non-JSON response. ';
        return [
            'HTML 500 from the API itself' => [
                500,
                ['Content-Type' => 'text/html', 'X-Request-Id' => 'v-918d0182-f8f6-11ee-ac5b-9f3072a91621'],
                '<html><body><h1>Internal Server Error</h1></body></html>',
                $prefix . 'Status 500 (text/html). Request ID v-918d0182-f8f6-11ee-ac5b-9f3072a91621. '
                . 'Body starts with: Internal Server Error',
            ],
            'HTML 504 from a gateway' => [
                504,
                ['Content-Type' => 'text/html', 'X-Request-Id' => 'v-918d0182-f8f6-11ee-ac5b-9f3072a91621'],
                "<html>\n<head><title>504 Gateway Time-out</title></head>\n"
                . "<body>\n<h1>504 Gateway Time-out</h1>\n</body>\n</html>",
                $prefix . 'Status 504 (text/html). Request ID v-918d0182-f8f6-11ee-ac5b-9f3072a91621. '
                . 'Body starts with: 504 Gateway Time-out 504 Gateway Time-out',
            ],
            'HTML 404 whose <head> starts with a script' => [
                404,
                ['Content-Type' => 'text/html; charset=UTF-8'],
                "<html><head><script>window._vwo_code || (function () { var account_id=818639 })();</script>"
                . "<style>body{opacity:0}</style><title>Page not found</title></head>"
                . "<body><h1>Page not found</h1></body></html>",
                $prefix . 'Status 404 (text/html; charset=UTF-8). Request ID none. '
                . 'Body starts with: Page not found Page not found',
            ],
            'plain-text 504 synthesized by Cloudflare' => [
                504,
                ['Content-Type' => 'text/plain; charset=UTF-8', 'CF-Ray' => '9a1b2c3d4e5f6789-BRU'],
                'error code: 504',
                $prefix . 'Status 504 (text/plain; charset=UTF-8). Request ID none; CF-Ray 9a1b2c3d4e5f6789-BRU. '
                . 'Body starts with: error code: 504',
            ],
            'plain-text 401 without a request ID' => [
                401,
                ['Content-Type' => 'text/plain'],
                'Unauthorized',
                $prefix . 'Status 401 (text/plain). Request ID none. Body starts with: Unauthorized',
            ],
            '200 with a truncated JSON body' => [
                200,
                ['Content-Type' => 'application/json'],
                '{"id": "8ff6c046-ec64-4ce4-bea6-27845ec1',
                $prefix . 'Status 200 (application/json). Request ID none. '
                . 'Body starts with: {"id": "8ff6c046-ec64-4ce4-bea6-27845ec1',
            ],
            'no Content-Type header' => [
                503,
                [],
                'Service Unavailable',
                $prefix . 'Status 503 (no Content-Type). Request ID none. Body starts with: Service Unavailable',
            ],
            'excerpt stops at 200 characters, not bytes' => [
                502,
                ['Content-Type' => 'text/plain'],
                str_repeat('é', 201),
                $prefix . 'Status 502 (text/plain). Request ID none. Body starts with: ' . str_repeat('é', 200),
            ],
        ];
    }

    public function testClearQuery(): void
    {
        $client = $this->getMockClient();

        $client->addQuery('filter', 'name=dev');
        $this->assertEquals(['filter' => 'name=dev'], $client->getQuery());

        $client->clearQuery();
        $this->assertTrue(empty($client->getQuery()));
    }

    public function testOptions(): void
    {
        $client = $this->getMockClient();

        $client->addOption('verify', 'false');
        $client->addOption('curl.options', ['CURLOPT_RETURNTRANSFER' => true]);
        $client->addOption('curl.options', ['CURLOPT_FILE' => '/tmp/foo']);

        $expectedOptions = [
            'verify' => 'false',
            'curl.options' => [
                'CURLOPT_RETURNTRANSFER' => true,
                'CURLOPT_FILE' => '/tmp/foo',
            ],
        ];

        $this->assertEquals($expectedOptions, $client->getOptions());

        $client->clearOptions();
        $this->assertTrue(empty($client->getOptions()));
    }

    public function testModifyOptions(): void
    {
        $client = $this->getMockClient();

        // Set a number of options and queries as a dependent library would.
        $client->addOption('headers', ['User-Agent' => 'AcquiaCli/4.20']);
        // Add a user agent twice to ensure that we only see it once in the request.
        $client->addOption('headers', ['User-Agent' => 'AcquiaCli/4.20']);
        $client->addOption('headers', ['User-Agent' => 'ZCli/1.1.1']);
        $client->addOption('headers', ['User-Agent' => 'AaahCli/0.1']);
        $client->addQuery('filter', 'name=@*2014*');
        $client->addQuery('filter', 'type=@*true*');
        $client->addQuery('limit', '1');

        // Set options as an endpoint call would.
        $reflectionClass = new \ReflectionClass('AcquiaCloudApi\Connector\Client');

        $requestOptions = [
            'json' => [
                'source' => 'source',
                'message' => 'message',
            ],
        ];

        $providerProperty = $reflectionClass->getProperty('requestOptions');
        $providerProperty->setAccessible(true);
        $providerProperty->setValue($client, $requestOptions);

        // Modify the request to ensure that all of the above get merged correctly.
        // Run modifyOptions twice to ensure that multiple uses of it do not change
        // the end result.
        // @see https://github.com/typhonius/acquia-php-sdk-v2/issues/87
        $client->modifyOptions();
        $actualOptions = $client->modifyOptions();

        $version = $client->getVersion();
        $userAgent = <<<EOD
acquia-php-sdk-v2/%s (https://github.com/typhonius/acquia-php-sdk-v2) AcquiaCli/4.20 ZCli/1.1.1 AaahCli/0.1
EOD;

        $expectedOptions = [
            'headers' => [
                'User-Agent' => sprintf($userAgent, $version)
            ],
            'json' => [
                'source' => 'source',
                'message' => 'message'
            ],
            'query' => [
                'filter' => 'name=@*2014*,type=@*true*',
                'limit' => '1'
            ]
        ];

        $this->assertEquals($expectedOptions, $actualOptions);
    }

    public function testVersion(): void
    {
        $reflectionClass = new \ReflectionClass('AcquiaCloudApi\Connector\Client');
        $constants = $reflectionClass->getConstants();
        $reflectionVersion = $constants['VERSION'];

        $client = $this->getMockClient();
        $methodVersion = $client->getVersion();

        $this->assertEquals($methodVersion, $reflectionVersion);
    }
}
