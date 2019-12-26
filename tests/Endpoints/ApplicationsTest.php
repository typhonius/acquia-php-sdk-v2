<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Applications;

class ApplicationsTest extends CloudApiTestCase
{

    protected $properties = [
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

    protected $tagProperties = [
        'name',
        'color',
        'context',
        'links'
    ];

    public function testGetApplications()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Applications/getAllApplications.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $application = new Applications($client);
        $result = $application->getAll();

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\ApplicationsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\ApplicationResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetApplication()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Applications/getApplication.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $application = new Applications($client);
        $result = $application->get('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\ApplicationsResponse', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\ApplicationResponse', $result);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testRenameApplication()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Applications/renameApplication.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $application = new Applications($client);
        $result = $application->rename('8ff6c046-ec64-4ce4-bea6-27845ec18600', "My application's new name");

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Application renamed.', $result->message);
    }

    public function testGetAllTags()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Applications/getAllTags.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $application = new Applications($client);
        $result = $application->getAllTags('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\TagsResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\TagResponse', $record);

            foreach ($this->tagProperties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testCreateTag()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Applications/createTag.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $application = new Applications($client);
        $result = $application->createTag('8ff6c046-ec64-4ce4-bea6-27845ec18600', "deloitte", "orange");

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('The tag has been added to the application.', $result->message);
    }

    public function testDeleteTag()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Applications/deleteTag.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $application = new Applications($client);
        $result = $application->deleteTag('8ff6c046-ec64-4ce4-bea6-27845ec18600', "deloitte");

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('The tag has been removed from the application.', $result->message);
    }
}
