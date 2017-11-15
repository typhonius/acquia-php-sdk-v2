<?php

namespace AcquiaCloudApi\Response;

/**
 * Class DatabasesResponse
 * @package AcquiaCloudApi\Response
 */
class DatabasesResponse extends \ArrayObject
{

    /**
     * DatabasesResponse constructor.
     * @param array $databases
     */
    public function __construct($databases)
    {
        parent::__construct(array_map(function ($database) {
            return new DatabaseResponse($database);
        }, $databases), self::ARRAY_AS_PROPS);
    }
}
