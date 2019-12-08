<?php

namespace AcquiaCloudApi\Connector;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\BadResponseException;
use AcquiaCloudApi\Exception\ApiErrorException;
use Psr\Http\Message\StreamInterface;

/**
 * Class Client
 * @package AcquiaCloudApi\CloudApi
 */
class Client implements ClientInterface
{
    /** @var ConnectorInterface The API connector. */
    protected $connector;

    /** @var array Query strings to be applied to the request. */
    protected $query = [];

    /**
     * Client constructor.
     *
     * @param ConnectorInterface $connector
     */
    public function __construct(ConnectorInterface $connector)
    {
        $this->connector = $connector;
    }

    /**
     * Client factory method for instantiating .
     *
     * @param ConnectorInterface $connector
     *
     * @return static
     */
    public static function factory(ConnectorInterface $connector)
    {
        $client = new static(
            $connector
        );

        return $client;
    }

    /**
     * Takes parameters passed in, makes a request to the API, and processes the response.
     *
     * @param string $verb
     * @param string $path
     * @param array  $options
     *
     * @return StreamInterface
     */
    public function request(string $verb, string $path, array $options = [])
    {
        $options['query'] = $this->query;

        if (!empty($options['query']['filter']) && is_array($options['query']['filter'])) {
            // Default to an AND filter.
            $options['query']['filter'] = implode(',', $options['query']['filter']);
        }
        $response = $this->makeRequest($verb, $path, $options);

        return $this->processResponse($response);
    }

    /**
     * Makes a request to the API.
     *
     * @param string $verb
     * @param string $path
     * @param array  $options
     *
     * @return ResponseInterface
     */
    public function makeRequest(string $verb, string $path, array $options = [])
    {
        try {
            $response = $this->connector->sendRequest($verb, $path, $options);
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
        }

        return $response;
    }

    /**
     * Processes the returned response from the API.
     *
     * @param ResponseInterface $response
     * @return StreamInterface
     * @throws \Exception
     */
    public function processResponse(ResponseInterface $response)
    {

        $body = $response->getBody();

        $object = json_decode($body);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return $body;
        }

        if (property_exists($object, '_embedded') && property_exists($object->_embedded, 'items')) {
            return $object->_embedded->items;
        }

        if (property_exists($object, 'error') && property_exists($object, 'message')) {
            throw new ApiErrorException($object);
        }

        return $object;
    }

    /**
     * Get query from Client.
     *
     * @return array
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Clear query.
     */
    public function clearQuery()
    {
        $this->query = [];
    }

    /**
     * Add a query parameter to filter results.
     *
     * @param string     $name
     * @param string|int $value
     */
    public function addQuery($name, $value)
    {
        $this->query = array_merge_recursive($this->query, [$name => $value]);
    }
}
