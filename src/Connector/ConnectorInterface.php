<?php

namespace AcquiaCloudApi\Connector;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Interface ConnectorInterface
 *
 * @package AcquiaCloudApi\CloudApi
 */
interface ConnectorInterface
{

    /**
     * Connector constructor.
     *
     * @param array $config
     */
    public function __construct(array $config);

    /**
     * Creates an authenticated Request instance.
     *
     * @param string $verb
     * @param string $path
     *
     * @return RequestInterface
     */
    public function createRequest($verb, $path);

    /**
     * Sends the request to the API using Guzzle.
     *
     * @param string $verb
     * @param string $path
     * @param array $options
     *
     * @return ResponseInterface
     */
    public function sendRequest($verb, $path, $options);
}
