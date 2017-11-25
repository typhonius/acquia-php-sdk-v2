<?php

namespace AcquiaCloudApi\CloudApi;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Interface ConnectorInterface
 * @package AcquiaCloudApi\CloudApi
 */
interface ConnectorInterface
{
    /**
     * @param string $verb
     * @param string $path
     * @param array  $query
     * @param array  $options
     *
     * @return object|array|StreamInterface
     */
    public function request(string $verb, string $path, array $query = [], array $options = array());

    /**
     * @param string $verb
     * @param string $path
     * @param array  $query
     * @param array  $options
     * @return ResponseInterface
     */
    public function makeRequest(string $verb, string $path, array $query = [], array $options = array());

    /**
     * @param ResponseInterface $response
     * @return object|array|StreamInterface
     * @throws \Exception
     */
    public function processResponse(ResponseInterface $response);
}
