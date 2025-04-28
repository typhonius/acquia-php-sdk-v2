<?php

namespace AcquiaCloudApi\Response;

use ArrayObject;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\CodebaseResponse>
 */
class CodebasesResponse extends \ArrayObject
{
    /**
     * @param array<object> $codebases
     */
    public function __construct(array $codebases)
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
