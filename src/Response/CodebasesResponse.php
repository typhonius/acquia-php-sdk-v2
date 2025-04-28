<?php

namespace AcquiaCloudApi\Response;

/**
 * Class CodebasesResponse
 * @package AcquiaCloudApi\Response
 */
class CodebasesResponse extends \ArrayObject
{
    /**
     * CodebasesResponse constructor.
     * @param array $codebases
     */
    public function __construct($codebases)
    {
        parent::__construct(
            array_map(
                function ($codebase) {
                    return new CodebaseResponse($codebase);
                },
                $codebases
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
