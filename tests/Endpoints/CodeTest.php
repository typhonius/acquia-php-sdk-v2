<?php

class CodeTest extends CloudApiTestCase
{

    public $properties = [
    'name',
    'flags',
    ];

    public function testGetBranches()
    {

        $response = (array) $this->generateCloudApiResponse('Endpoints/getCode.json');
        $branches = new \AcquiaCloudApi\Response\BranchesResponse($response);


        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['code'])
        ->getMock();
        $client->expects($this->once())
        ->method('code')
        ->with('8ff6c046-ec64-4ce4-bea6-27845ec18600')
        ->will($this->returnValue($branches));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->code('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\BranchesResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\BranchResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testCodeSwitch()
    {
        $response = $this->generateCloudApiResponse('Endpoints/switchCode.json');

        $message = new \AcquiaCloudApi\Response\OperationResponse($response);

        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['switchCode'])
        ->getMock();

        $client->expects($this->once())
        ->method('switchCode')
        ->with('8ff6c046-ec64-4ce4-bea6-27845ec18600', 'my-feature-branch')
        ->will($this->returnValue($message));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->switchCode('8ff6c046-ec64-4ce4-bea6-27845ec18600', 'my-feature-branch');
        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals('The code is being switched.', $result->message);
    }
}
