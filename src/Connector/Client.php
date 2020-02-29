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

    /** @var array Guzzle options to be applied to the request. */
    protected $options = [];

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
     * @inheritdoc
     */
    public function request(string $verb, string $path, array $options = [])
    {
        $options = $this->options;
        $options['query'] = $this->query;

        if (!empty($options['query']['filter']) && is_array($options['query']['filter'])) {
            // Default to an AND filter.
            $options['query']['filter'] = implode(',', $options['query']['filter']);
        }
        $response = $this->makeRequest($verb, $path, $options);

        return $this->processResponse($response);
    }

    /**
     * @inheritdoc
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
     * @inheritdoc
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
     * @inheritdoc
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @inheritdoc
     */
    public function clearQuery()
    {
        $this->query = [];
    }

    /**
     * @inheritdoc
     */
    public function addQuery($name, $value)
    {
        $this->query = array_merge_recursive($this->query, [$name => $value]);
    }

    /**
     * @inheritdoc
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @inheritdoc
     */
    public function clearOptions()
    {
        $this->options = [];
    }

    /**
     * @inheritdoc
     */
    public function addOption($name, $value)
    {
        $this->options = array_merge_recursive($this->options, [$name => $value]);
    }
}
