<?php

namespace AcquiaCloudApi\Response;

/**
 * @template TValue
 * @template-extends \ArrayObject<int,TValue>
 */
class InsightModulesResponse extends \ArrayObject
{

    /**
     * @param array<object> $modules
     */
    public function __construct($modules)
    {
        parent::__construct(
            array_map(
                function ($module) {
                    return new InsightModuleResponse($module);
                },
                $modules
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
