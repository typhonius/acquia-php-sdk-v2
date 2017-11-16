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
}
