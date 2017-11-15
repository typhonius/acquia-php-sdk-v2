<?php

namespace AcquiaCloudApi\Response;

/**
 * Class OperationResponse
 * @package AcquiaCloudApi\Response
 */
class OperationResponse
{

    public $message;

    /**
     * ApplicationResponse constructor.
     * @param object $operation
     */
    public function __construct($operation)
    {
        $this->message = $operation->message;
    }
}
