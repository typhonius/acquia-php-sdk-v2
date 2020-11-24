<?php

namespace AcquiaCloudApi\Response;

class OperationResponse
{

    /**
     * @var string $message
     */
    public $message;

    /**
     * @var object|null $links
     */
    public $links;

    /**
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
