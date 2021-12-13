<?php

namespace AcquiaCloudApi\Exception;

use Exception;

/**
 * Represents an error returned from the API.
 */
class ApiErrorException extends Exception
{
    /**
     * @var object
     */
    private $responseBody;

    /**
     * @var string
     */
    private $errorType;

    /**
     * ApiErrorException Constructor.
     *
     * @param object    $response_body
     * @param string    $message
     * @param int       $code
     * @param Exception $previous
     */
    public function __construct($response_body, $message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->setResponseBody($response_body);
        $this->setError($response_body);
    }

    /**
     * __toString() magic method.
     */
    public function __toString()
    {
        return __CLASS__ . ": [{$this->errorType}]: {$this->message}\n";
    }

    /**
     * Sets message and errorType properties.
     *
     * @param object $response_body
     */
    private function setError($response_body): void
    {
        if (is_array($response_body->message) || is_object($response_body->message)) {
            $output = '';
            foreach ($response_body->message as $message) {
                $output .= $message . PHP_EOL;
            }
            $this->message = $output;
        } else {
            $this->errorType = $response_body->error;
            $this->message = $response_body->message;
        }
    }

    /**
     * @return object
     */
    public function getResponseBody()
    {
        return $this->responseBody;
    }

    /**
     * @param object $response_body
     */
    private function setResponseBody($response_body): void
    {
        $this->responseBody = $response_body;
    }
}
