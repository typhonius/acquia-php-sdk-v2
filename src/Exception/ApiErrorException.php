<?php

namespace AcquiaCloudApi\Exception;

use GuzzleHttp\Exception\BadResponseException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Represents an error returned from the API.
 */
class ApiErrorException extends BadResponseException
{
    public $errorType;

    /**
     * @inheritdoc
     */
    public function __construct(
        $object,
        RequestInterface $request,
        ResponseInterface $response = null,
        \Exception $previous = null,
        array $handlerContext = []
    ) {
        $this->setError($object);
        parent::__construct($this->message, $request, $response, $previous, $handlerContext);
    }

    /**
     * __toString() magic method.
     */
    public function __toString()
    {
        return __CLASS__ . ": [{$this->errorType}]: {$this->message}\n";
    }

    /**
     * Sets the error.
     *
     * @param object $object
     */
    public function setError($object)
    {
        $this->errorType = $object->error;
        if (is_array($object->message) || is_object($object->message)) {
            $output = '';
            foreach ($object->message as $message) {
                $output .= $message . PHP_EOL;
            }
            $this->message = $output;
        } else {
            $this->message = $object->message;
        }
    }

    /**
     * Gets the type of error throw from CloudAPI.
     */
    public function getErrorType()
    {
        return $this->errorType;
    }
}
