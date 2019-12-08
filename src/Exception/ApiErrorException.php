<?php

namespace AcquiaCloudApi\Exception;

use \Exception;

/**
 * Represents an error returned from the API.
 */
class ApiErrorException extends Exception
{
    public function __construct($object, $message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->setError($object);
    }

    // custom string representation of object
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    public function setError($object)
    {
        if (is_array($object->message)) {
            $output = '';
            foreach ($object->message as $message) {
                $output .= $message . PHP_EOL;
            }
            $this->message = $output;
        } else {
            $this->message = $object->message;
        }
    }
}
