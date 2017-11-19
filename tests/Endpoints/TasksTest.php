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
        $tasks = new \AcquiaCloudApi\Response\TasksResponse($response);


        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['tasks'])
        ->getMock();
        $client->expects($this->once())
        ->method('tasks')
        ->with('8ff6c046-ec64-4ce4-bea6-27845ec18600')
        ->will($this->returnValue($tasks));

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

    public function testGetFilteredTasks()
    {
        //      $this->cloudapi->addQuery('from', $start->format(\DateTime::ATOM));
        //      $this->cloudapi->addQuery('filter', "name=@*${match}*");
        //      $tasks = $this->cloudapi->tasks($uuid);
        //      $this->cloudapi->clearQuery();
        //
        //      $mock->expects($this->exactly(2))
        //        ->method('set')
        //        ->withConsecutive(
        //          [$this->equalTo('foo'), $this->greaterThan(0)],
        //          [$this->equalTo('bar'), $this->greaterThan(0)]
        //        );


        $response = $this->generateCloudApiResponse('Endpoints/getFilteredTasks.json');
        $insights = new \AcquiaCloudApi\Response\TasksResponse($response);


        $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
        ->disableOriginalConstructor()
        ->setMethods(['tasks', 'addQuery', 'clearQuery'])
        ->getMock();
        $client->expects($this->once())
        ->method('addQuery')
        ->with('filter', 'name=@DatabaseBackupCreated');
        $client->expects($this->once())
        ->method('tasks')
        ->with('8ff6c046-ec64-4ce4-bea6-27845ec18600')
        ->will($this->returnValue($insights));
        $client->expects($this->once())
        ->method('clearQuery');

        /** @var AcquiaCloudApi\CloudApi\Client $client */
        $client->addQuery('filter', 'name=@DatabaseBackupCreated');
        $result = $client->tasks('8ff6c046-ec64-4ce4-bea6-27845ec18600');
        $client->clearQuery();

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
