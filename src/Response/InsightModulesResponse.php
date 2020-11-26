<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<InsightModuleResponse>
 */
class InsightModulesResponse extends CollectionResponse
{

    /**
     * @param array<object> $modules
     */
    public function __construct($modules)
    {
        parent::__construct('InsightModuleResponse', $modules);
    }
}
