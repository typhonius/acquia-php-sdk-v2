<?php

namespace AcquiaCloudApi\Exception;

use Exception;

/**
 * Represents an error returned from the API.
 */
class ApiErrorException extends Exception
{
    private object $responseBody;

    private string $errorType;

    /**
     * ApiErrorException Constructor.
     */
    public function __construct(object $response_body, string $message = "", int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->setResponseBody($response_body);
        $this->setError($response_body);
    }

    /**
     * __toString() magic method.
     */
    public function __toString(): string
    {
        return __CLASS__ . ": [{$this->errorType}]: {$this->message}\n";
    }

    /**
     * Sets message and errorType properties.
     */
    private function setError(object $response_body): void
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

    public function getResponseBody(): object
    {
        return $this->responseBody;
    }

    private function setResponseBody(object $response_body): void
    {
        $this->responseBody = $response_body;
    }
}
