<?php

namespace AcquiaCloudApi\CloudApi;

use Acquia\Hmac\Guzzle\HmacAuthMiddleware;
use Acquia\Hmac\Key;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use GuzzleHttp\HandlerStack;

/**
 * Class Connector
 * @package AcquiaCloudApi\CloudApi
 */
class Connector implements ConnectorInterface
{
    /**
     * @var string BASE_URI
     */
    const BASE_URI = 'https://cloud.acquia.com/api';

    /**
     * @var GuzzleClient The Guzzle Client to communicate with the API.
     */
    protected $client;

    /**
     * @var array Injected configuration values.
     */
    protected $config;

    /**
     * Connector constructor.
     *
     * @param array $config
     */
    public function __construct($config)
    {
        $key = new Key($config['key'], $config['secret']);
        $middleware = new HmacAuthMiddleware($key);
        $stack = HandlerStack::create();
        $stack->push($middleware);

        $this->client = new GuzzleClient([
            'handler' => $stack,
        ]);
    }

    /**
     * Takes parameters passed in, makes a request to the API, and processes the response.
     *
     * @param string $verb
     * @param string $path
     * @param array  $query
     * @param array  $options
     *
     * @return object|array|StreamInterface
     */
    public function request(string $verb, string $path, array $query = [], array $options = [])
    {
        $options['query'] = $query;

        if (!empty($options['query']['filter']) && is_array($options['query']['filter'])) {
            // Default to an AND filter.
            $options['query']['filter'] = implode(',', $options['query']['filter']);
        }
        $response = $this->makeRequest($verb, $path, $query, $options);

        return $this->processResponse($response);
    }

    /**
     * Makes a request to the API.
     *
     * @param string $verb
     * @param string $path
     * @param array  $query
     * @param array  $options
     * @return ResponseInterface
     */
    public function makeRequest(string $verb, string $path, array $query = [], array $options = [])
    {
        try {
            $response = $this->client->$verb(self::BASE_URI . $path, $options);
        } catch (ClientException $e) {
            print $e->getMessage();
            $response = $e->getResponse();
        }

        return $response;
    }

    /**
     * Processes the returned response from the API.
     *
     * @param ResponseInterface $response
     * @return object|array|StreamInterface
     * @throws \Exception
     */
    public function processResponse(ResponseInterface $response)
    {

        $body = $response->getBody();

        $object = json_decode($body);
        if (json_last_error() === JSON_ERROR_NONE) {
            // JSON is valid
            if (property_exists($object, '_embedded') && property_exists($object->_embedded, 'items')) {
                $return = $object->_embedded->items;
            } elseif (property_exists($object, 'error')) {
                throw new \Exception($object->message);
            } else {
                $return = $object;
            }
        } else {
            $return = $body;
        }

        return $return;
    }
}
