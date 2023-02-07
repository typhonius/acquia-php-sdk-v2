<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Applications;

class ApplicationsTest extends CloudApiTestCase
{
    /**
     * @var array<string> $properties
     */
    protected array $properties = [
        'uuid',
        'name',
        'hosting',
        'subscription',
        'organization',
        'type',
        'flags',
        'status',
        'links'
    ];

    /**
     * @var array<string> $tagProperties
     */
    protected array $tagProperties = [
        'name',
        'color',
        'context',
        'links'
    ];

    public function testGetApplications(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Applications/getAllApplications.json');
        $client = $this->getMockClient($response);

        $application = new Applications($client);
        $application->getAll();
    }

    public function testGetApplication(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Applications/getApplication.json');
        $client = $this->getMockClient($response);

        $application = new Applications($client);
        $application->get('8ff6c046-ec64-4ce4-bea6-27845ec18600');
    }

    public function testRenameApplication(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Applications/renameApplication.json');
        $client = $this->getMockClient($response);

        $application = new Applications($client);
        $result = $application->rename('8ff6c046-ec64-4ce4-bea6-27845ec18600', "My application's new name");

        $requestOptions = [
            'json' => [
                'name' => "My application's new name",
            ],
        ];

        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals('Application renamed.', $result->message);
    }

    public function testGetAllTags(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Applications/getAllTags.json');
        $client = $this->getMockClient($response);

        $application = new Applications($client);
        $application->getAllTags('8ff6c046-ec64-4ce4-bea6-27845ec18600');
    }

    public function testCreateTag(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Applications/createTag.json');
        $client = $this->getMockClient($response);

        $application = new Applications($client);
        $result = $application->createTag('8ff6c046-ec64-4ce4-bea6-27845ec18600', "deloitte", "orange");

        $requestOptions = [
            'json' => [
                'name' => 'deloitte',
                'color' => 'orange',
            ],
        ];

        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals('The tag has been added to the application.', $result->message);
    }

    public function testDeleteTag(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Applications/deleteTag.json');
        $client = $this->getMockClient($response);

        $application = new Applications($client);
        $result = $application->deleteTag('8ff6c046-ec64-4ce4-bea6-27845ec18600', "deloitte");

        $this->assertEquals('The tag has been removed from the application.', $result->message);
    }
}
