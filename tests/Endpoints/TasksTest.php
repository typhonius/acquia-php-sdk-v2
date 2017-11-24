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

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getTasks.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
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

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getFilteredTasks.json');
        $client = $this->getMockClient($response);

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
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
