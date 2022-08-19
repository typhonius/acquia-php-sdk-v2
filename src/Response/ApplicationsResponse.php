<?php

namespace AcquiaCloudApi\Response;

use ArrayObject;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\ApplicationResponse>
 */
class ApplicationsResponse extends ArrayObject
{
    /**
     * @param array<object> $applications
     */
    public function __construct($applications)
    {
        parent::__construct(
            array_map(
                static function ($application) {
                    return new ApplicationResponse($application);
                },
                $applications
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
