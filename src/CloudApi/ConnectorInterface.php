<?php

namespace AcquiaCloudApi\CloudApi;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

interface ConnectorInterface
{
    /**
     * @param string $verb
     * @param string $path
     * @param array  $query
     * @param array  $options
     *
     * @return mixed|StreamInterface
     */
    public function request(string $verb, string $path, array $query = [], array $options = array());

    /**
     * @param string $verb
     * @param string $path
     * @param array  $query
     * @param array  $options
     * @return array|object
     */
    public function makeRequest(string $verb, string $path, array $query = [], array $options = array());

    /**
     * @param ResponseInterface $response
     * @return mixed|StreamInterface
     * @throws \Exception
     */
    public function processResponse(ResponseInterface $response);
}
