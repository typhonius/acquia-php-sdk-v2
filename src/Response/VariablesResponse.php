<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\VariableResponse>
 */
class VariablesResponse extends \ArrayObject
{
    /**
     * @param array<object> $variables
     */
    public function __construct(array $variables)
    {
        parent::__construct(
            array_map(
                static function ($variable) {
                    return new VariableResponse($variable);
                },
                $variables
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
