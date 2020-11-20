<?php

namespace AcquiaCloudApi\Response;

/**
 * @template TValue
 * @template-extends \ArrayObject<int,TValue>
 */
class DatabasesResponse extends \ArrayObject
{

    /**
     * @param array<object> $databases
     */
    public function __construct($databases)
    {
        parent::__construct(
            array_map(
                function ($database) {
                    return new DatabaseResponse($database);
                },
                $databases
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
