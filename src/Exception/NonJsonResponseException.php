<?php

namespace AcquiaCloudApi\Exception;

use JsonException;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

/**
 * The API (or a gateway in front of it) answered with something that is not JSON.
 *
 * The message carries what a user needs; the response is kept for callers
 * that can show more, such as the full body at a higher verbosity level.
 */
class NonJsonResponseException extends RuntimeException
{
    private ResponseInterface $response;

    public function __construct(string $message, ResponseInterface $response, ?JsonException $previous = null)
    {
        parent::__construct($message, previous: $previous);
        $this->response = $response;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
