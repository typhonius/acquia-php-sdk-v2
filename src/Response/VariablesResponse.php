<?php

namespace AcquiaCloudApi\Response;

/**
 * Class VariablesResponse
 *
 * @package AcquiaCloudApi\Response
 */
class VariablesResponse extends \ArrayObject
{

    /**
     * VariablesResponse constructor.
     *
     * @param array $variables
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
