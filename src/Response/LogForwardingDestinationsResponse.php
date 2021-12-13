<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\LogForwardingDestinationResponse>
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
