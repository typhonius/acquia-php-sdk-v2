<?php

namespace AcquiaCloudApi\Response;

/**
 * @template TValue
 * @template-extends \ArrayObject<int,TValue>
 */
class VariablesResponse extends \ArrayObject
{

    /**
     * @param array<object> $variables
     */
    public function __construct($variables)
    {
        parent::__construct(
            array_map(
                function ($variable) {
                    return new VariableResponse($variable);
                },
                $variables
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
