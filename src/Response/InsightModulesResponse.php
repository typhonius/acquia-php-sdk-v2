<?php

namespace AcquiaCloudApi\Response;

/**
 * Class InsightModulesResponse
 *
 * @package AcquiaCloudApi\Response
 */
class InsightModulesResponse extends \ArrayObject
{

    /**
     * InsightModulesResponse constructor.
     *
     * @param array $modules
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
