<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\EnvironmentResponse>
 */
class EnvironmentsResponse extends \ArrayObject
{

    /**
     * @param array<object> $environments
     */
    public function __construct($environments)
    {
        parent::__construct(
            array_map(
                function ($environment) {
                    return new EnvironmentResponse($environment);
                },
                $environments
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
