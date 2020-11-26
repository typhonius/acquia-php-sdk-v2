<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<VariableResponse>
 */
class VariablesResponse extends CollectionResponse
{

    /**
     * @param array<object> $variables
     */
    public function __construct($variables)
    {
        parent::__construct('VariableResponse', $variables);
    }
}
