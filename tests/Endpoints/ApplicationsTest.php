<?php

class ApplicationsTest extends CloudApiTestCase
{

    public $properties = [
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

    public function testGetApplications()
    {

        // @TODO make this an array in the response?
        $response = (array) $this->generateCloudApiResponse('Endpoints/getApplications.json');
        $applications = new \AcquiaCloudApi\Response\ApplicationsResponse($response);


        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['applications'])
        ->getMock();
        $client->expects($this->once())
        ->method('applications')
        ->will($this->returnValue($applications));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->applications();

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
        $response = $this->generateCloudApiResponse('Endpoints/getApplication.json');

        $application = new \AcquiaCloudApi\Response\ApplicationResponse($response);

        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['application'])
        ->getMock();

        $client->expects($this->once())
        ->method('application')
        ->with('8ff6c046-ec64-4ce4-bea6-27845ec18600')
        ->will($this->returnValue($application));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->application('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\ApplicationsResponse', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\ApplicationResponse', $result);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testRenameApplication()
    {
        $response = $this->generateCloudApiResponse('Endpoints/renameApplication.json');

        $message = new \AcquiaCloudApi\Response\OperationResponse($response);

        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['applicationRename'])
        ->getMock();

        $client->expects($this->once())
        ->method('applicationRename')
        ->with('8ff6c046-ec64-4ce4-bea6-27845ec18600', "My application's new name")
        ->will($this->returnValue($message));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->applicationRename('8ff6c046-ec64-4ce4-bea6-27845ec18600', "My application's new name");
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('Application renamed.', $result->message);
    }
}
