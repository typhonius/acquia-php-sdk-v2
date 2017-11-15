<?php

namespace AcquiaCloudApi\Response;

/**
 * Class ApplicationsResponse
 * @package AcquiaCloudApi\Response
 */
class ApplicationsResponse extends \ArrayObject
{

    /**
     * ApplicationsResponse constructor.
     * @param array $applications
     */
    public function __construct($applications)
    {
        parent::__construct(array_map(function ($application) {
            return new ApplicationResponse($application);
        }, $applications), self::ARRAY_AS_PROPS);
    }
}
