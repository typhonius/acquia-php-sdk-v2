<?php

namespace AcquiaCloudApi\CloudApi;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Interface ConnectorInterface
 *
 * @package AcquiaCloudApi\CloudApi
 */
interface ConnectorInterface
{
    /**
     * Makes a request to the API.
     *
     * @param string $verb
     * @param string $path
     * @param array  $query
     * @param array  $options
     *
     * @return object|array|StreamInterface
     */
    public function request(string $verb, string $path, array $query = [], array $options = []);

    /**
     * @param string $verb
     * @param string $path
     * @param array  $query
     * @param array  $options
     * @return ResponseInterface
     */
    public function makeRequest(string $verb, string $path, array $query = [], array $options = []);

    /**
     * Processes the returned response from the API.
     *
     * @param ResponseInterface $response
     * @return object|array|StreamInterface
     * @throws \Exception
     */
    public function processResponse(ResponseInterface $response);
}
