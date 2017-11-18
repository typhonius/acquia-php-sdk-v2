<?php

class ServersTest extends CloudApiTestCase
{

    public $properties = [
    'id',
    'name',
    'hostname',
    'ip',
    'status',
    'region',
    'roles',
    'amiType',
    'configuration',
    'flags',
    ];

    public function testGetServers()
    {

        $response = $this->generateCloudApiResponse('Endpoints/getServers.json');
        $servers = new \AcquiaCloudApi\Response\ServersResponse($response);


        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['servers'])
        ->getMock();
        $client->expects($this->once())
        ->method('servers')
        ->with('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851')
        ->will($this->returnValue($servers));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->servers('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\ServersResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\ServerResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

//    public function testGetApplication()
//    {
//        $response = $this->generateCloudApiResponse('Endpoints/getApplication.json');
//
//        $application = new \AcquiaCloudApi\Response\ApplicationResponse($response);
//
//        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
//        ->disableOriginalConstructor()
//        ->setMethods(['servers'])
//        ->getMock();
//
//        $client->expects($this->once())
//        ->method('servers')
//        ->with('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851')
//        ->will($this->returnValue($application));
//
//        /** @var AcquiaCloudApi\CloudApi\Client $client */
//        $result = $client->application('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');
//
//        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\ApplicationsResponse', $result);
//        $this->assertInstanceOf('\AcquiaCloudApi\Response\ApplicationResponse', $result);
//
//        foreach ($this->properties as $property) {
//            $this->assertObjectHasAttribute($property, $result);
//        }
//    }
//
//    public function testRenameApplication()
//    {
//        $response = $this->generateCloudApiResponse('Endpoints/renameApplication.json');
//
//        $message = new \AcquiaCloudApi\Response\OperationResponse($response);
//
//        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
//        ->disableOriginalConstructor()
//        ->setMethods(['applicationRename'])
//        ->getMock();
//
//        $client->expects($this->once())
//        ->method('applicationRename')
//        ->with('8ff6c046-ec64-4ce4-bea6-27845ec18600', "My application's new name")
//        ->will($this->returnValue($message));
//
//        /** @var AcquiaCloudApi\CloudApi\Client $client */
//        $result = $client->applicationRename('8ff6c046-ec64-4ce4-bea6-27845ec18600', "My application's new name");
//
//        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
//
//        $this->assertEquals('Application renamed.', $result->message);
//    }
}
