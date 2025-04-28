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
        $codebaseResponses = [];
        foreach ($codebases as $codebase) {
            $codebaseResponses[] = new CodebaseResponse($codebase);
        }

        parent::__construct($codebaseResponses, self::ARRAY_AS_PROPS);
    }
}
