<?php

namespace AcquiaCloudApi\Response;

/**
 * Class TasksResponse
 * @package AcquiaCloudApi\Response
 */
class TasksResponse extends \ArrayObject
{

    /**
     * ApplicationsResponse constructor.
     * @param array $tasks
     */
    public function __construct($tasks)
    {
        parent::__construct(array_map(function ($task) {
            return new TaskResponse($task);
        }, $tasks), self::ARRAY_AS_PROPS);
    }
}
