<?php

namespace AcquiaCloudApi\Exception;

use \Exception;

/**
 * Represents an error returned from the API.
 */
class ApiErrorException extends Exception
{
    public $errorType;

    /**
     * ApiErrorException Constructor.
     *
     * @param object    $object
     * @param string    $message
     * @param int       $code
     * @param Exception $previous
     */
    public function __construct($object, $message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->setError($object);
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
