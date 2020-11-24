<?php

namespace AcquiaCloudApi\Response;

/**
 * @template TValue
 * @template-extends \ArrayObject<int,TValue>
 */
class ApplicationsResponse extends \ArrayObject
{

    /**
     * @param array<object> $applications
     */
    public function __construct($applications)
    {
        parent::__construct(
            array_map(
                function ($application) {
                    return new ApplicationResponse($application);
                },
                $applications
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
