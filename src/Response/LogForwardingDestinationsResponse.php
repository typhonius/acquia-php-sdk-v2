<?php

namespace AcquiaCloudApi\Response;

/**
 * Class LogForwardingDestinationsResponse
 *
 * @package AcquiaCloudApi\Response
 */
class LogForwardingDestinationsResponse extends \ArrayObject
{

    /**
     * LogForwardingDestinationsResponse constructor.
     *
     * @param array $destinations
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
