<?php

class TasksTest extends CloudApiTestCase
{

    public $properties = [
    'uuid',
    'user',
    'name',
    'description',
    'title',
    'createdAt',
    'startedAt',
    'completedAt',
    'status',
    'type',
    'metadata',
    ];


    public function testGetTasks()
    {

        $response = $this->generateCloudApiResponse('Endpoints/getTasks.json');
        $insights = new \AcquiaCloudApi\Response\TasksResponse($response);


        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['tasks'])
        ->getMock();
        $client->expects($this->once())
        ->method('tasks')
        ->with('8ff6c046-ec64-4ce4-bea6-27845ec18600')
        ->will($this->returnValue($insights));

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $result = $client->tasks('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\TasksResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\TaskResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

}
