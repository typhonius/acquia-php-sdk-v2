<?php

namespace AcquiaCloudApi\Response;

/**
 * @template TValue
 * @template-extends \ArrayObject<int,TValue>
 */
class LogForwardingDestinationsResponse extends \ArrayObject
{

    /**
     * @param array<object> $destinations
     */
    public function __construct($destinations)
    {
        parent::__construct(
            array_map(
                function ($destination) {
                    return new LogForwardingDestinationResponse($destination);
                },
                $destinations
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
