<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\InsightModuleResponse>
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
