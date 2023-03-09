<?php

namespace AcquiaCloudApi\Response;

class OperationResponse
{
    public string $message;

    public ?object $links;

    /**
     */
    public function __construct(object $operation)
    {
        $this->message = $operation->message;
        if (isset($operation->_links)) {
            $this->links = $operation->_links;
        }
    }
}
