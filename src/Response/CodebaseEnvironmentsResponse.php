<?php

namespace AcquiaCloudApi\Response;

use ArrayObject;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\CodebaseEnvironmentResponse>
 */
class CodebaseEnvironmentsResponse extends ArrayObject
{
    /**
     * @param array<object> $environments
     */
    public function __construct(array $environments)
    {
        parent::__construct(
            array_map(
                static function ($environment) {
                    return new CodebaseEnvironmentResponse($environment);
                },
                $environments
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
