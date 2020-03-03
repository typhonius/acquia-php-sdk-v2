<?php

namespace AcquiaCloudApi\Connector;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\BadResponseException;
use AcquiaCloudApi\Exception\ApiErrorException;

/**
 * Interface ClientInterface
 *
 * @package AcquiaCloudApi\CloudApi
 */
interface ClientInterface
{

    /**
     * Takes parameters passed in, makes a request to the API, and processes the response.
     *
     * @param string $verb
     * @param string $path
     * @param array  $options
     *
     * @return mixed|StreamInterface
     */
    public function request(string $verb, string $path, array $options = []);

    /**
     * @param  string $verb
     * @param  string $path
     * @param  array  $options
     * @return ResponseInterface
     */
    public function makeRequest(string $verb, string $path, array $options = []);

    /**
     * Processes the returned response from the API.
     *
     * @param  ResponseInterface $response
     * @return mixed|StreamInterface
     * @throws \Exception
     */
    public function processResponse(ResponseInterface $response);

    /**
     * Get query from Client.
     *
     * @return array
     */
    public function getQuery();

    /**
     * Clear query.
     */
    public function clearQuery();

    /**
     * Add a query parameter to filter results.
     *
     * @param string     $name
     * @param string|int $value
     */
    public function addQuery($name, $value);

    /**
     * Get options from Client.
     *
     * @return array
     */
    public function getOptions();

    /**
     * Clear options.
     */
    public function clearOptions();

    /**
     * Add an option to the Guzzle request object.
     *
     * @param string $name
     * @param mixed  $value
     */
    public function addOption($name, $value);
}
