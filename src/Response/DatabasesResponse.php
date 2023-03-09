<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\DatabaseResponse>
 */
class DatabasesResponse extends \ArrayObject
{
    /**
     * @param array<object> $databases
     */
    public function __construct(array $databases)
    {
        parent::__construct(
            array_map(
                static function ($database) {
                    return new DatabaseResponse($database);
                },
                $databases
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
