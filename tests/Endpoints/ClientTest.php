<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Connector\Client;
use AcquiaCloudApi\Connector\Connector;
use AcquiaCloudApi\Endpoints\Code;

class ClientTest extends CloudApiTestCase
{

    public function testAddQuery()
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

    public function testFilteredQuery()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Client/getFilteredCode.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $client->addQuery('filter', 'name=@*2014*');
        $client->addQuery('filter', 'type=@*true*');
        $code = new Code($client);
        $result = $code->getAll('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        foreach ($result as $record) {
            $this->assertContains('2014', $record->name);
        }
    }

    public function testClearQuery()
    {
        $client = $this->getMockClient();

        $client->addQuery('filter', 'name=dev');
        $this->assertEquals(['filter' => 'name=dev'], $client->getQuery());

        $client->clearQuery();
        $this->assertTrue(empty($client->getQuery()));
    }

    public function testOptions()
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

    public function testModifyOptions()
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
        $options = [
            'json' => [
                'source' => 'source',
                'message' => 'message',
            ],
        ];

        // Modify the request to ensure that all of the above get merged correctly.
        // Run modifyOptions twice to ensure that multiple uses of it do not change
        // the end result.
        // @see https://github.com/typhonius/acquia-php-sdk-v2/issues/87
        $client->modifyOptions($options);
        $actualOptions = $client->modifyOptions($options);

        $version = $client->getVersion();
        $expectedOptions = [
            'headers' => [
                'User-Agent' => sprintf('acquia-php-sdk-v2/%s (https://github.com/typhonius/acquia-php-sdk-v2) AcquiaCli/4.20 ZCli/1.1.1 AaahCli/0.1', $version)
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

    public function testVersion()
    {
        $versionFile = sprintf('%s/VERSION', dirname(dirname(__DIR__)));
        $version = trim(file_get_contents($versionFile));

        $client = $this->getMockClient();
        $actualValue = $client->getVersion();

        $this->assertEquals($version, $actualValue);
    }

    public function testMissingVersion()
    {
        $versionFile = sprintf('%s/VERSION', dirname(dirname(__DIR__)));
        $versionFileBak = sprintf('%s.bak', $versionFile);
        rename($versionFile, $versionFileBak);

        try {
            $client = $this->getMockClient();
            $version = $client->getVersion();
        } catch (\Exception $e) {
            $this->assertEquals('Exception', get_class($e));
            $this->assertEquals('No VERSION file', $e->getMessage());
        }
        rename($versionFileBak, $versionFile);
    }
}
