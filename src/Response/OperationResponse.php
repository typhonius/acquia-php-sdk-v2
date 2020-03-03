<?php

namespace AcquiaCloudApi\Response;

/**
 * Class OperationResponse
 *
 * @package AcquiaCloudApi\Response
 */
class OperationResponse
{

    public $message;
    public $links;

    /**
     * ApplicationResponse constructor.
     *
     * @param object $operation
     */
    public function __construct($operation)
    {
        $this->message = $operation->message;
        if (isset($operation->_links)) {
            $this->links = $operation->_links;
        }
    }
}
