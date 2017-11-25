<?php

namespace AcquiaCloudApi\Response;

/**
 * Class EnvironmentsResponse
 * @package AcquiaCloudApi\Response
 */
class EnvironmentsResponse extends \ArrayObject
{

    /**
     * EnvironmentsResponse constructor.
     * @param array $environments
     */
    public function __construct($environments)
    {
        parent::__construct(array_map(function ($environment) {
            return new EnvironmentResponse($environment);
        }, $environments), self::ARRAY_AS_PROPS);
    }
}
