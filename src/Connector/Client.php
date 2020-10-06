<?php

namespace AcquiaCloudApi\Connector;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\BadResponseException;
use AcquiaCloudApi\Exception\ApiErrorException;
use Psr\Http\Message\StreamInterface;

/**
 * Class Client
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Client implements ClientInterface
{
    /**
     * @var ConnectorInterface The API connector.
     */
    protected $connector;

    /**
     * @var array Query strings to be applied to the request.
     */
    protected $query = [];

    /**
     * @var array Guzzle options to be applied to the request.
     */
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
     * Client factory method for instantiating.
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
     * Returns the current version of the library.
     *
     * @return string
     * @throws \Exception
     */
    public function getVersion()
    {
        if ($file = @file_get_contents(dirname(dirname(__DIR__)) . '/VERSION')) {
            return trim($file);
        } else {
            throw new \Exception('No VERSION file');
        }
    }

    /**
     * Allows the library to modify the request prior to making the call to the API.
     */
    public function modifyOptions($options = []): array
    {
        // Combine options set globally e.g. headers with options set by individual API calls e.g. form_params.
        $options = $this->options + $options;

        // This library can be standalone or as a dependency. Dependent libraries may also set their own user agent
        // which will make $options['headers']['User-Agent'] an array.
        // We need to array_unique() the array of User-Agent headers as multiple calls may include multiple of the same header.
        // We also use array_unshift() to place this library's user agent first to order to have it appear at the beginning of log files.
        // As Guzzle joins arrays with a comma, we must implode with a space here to pass Guzzle a string.
        $userAgent = sprintf(
            "%s/%s (https://github.com/typhonius/acquia-php-sdk-v2)",
            'acquia-php-sdk-v2',
            $this->getVersion()
        );
        if (isset($options['headers']['User-Agent']) && is_array($options['headers']['User-Agent'])) {
            array_unshift($options['headers']['User-Agent'], $userAgent);
            $options['headers']['User-Agent'] = implode(' ', array_unique($options['headers']['User-Agent']));
        } else {
            $options['headers']['User-Agent'] = $userAgent;
        }

        $options['query'] = $this->query;
        if (!empty($options['query']['filter']) && is_array($options['query']['filter'])) {
            // Default to an OR filter to increase returned responses.
            $options['query']['filter'] = implode(',', $options['query']['filter']);
        }

        return $options;
    }

    /**
     * @inheritdoc
     */
    public function request(string $verb, string $path, array $options = [])
    {
        // @TODO follow this up by removing $options from the parameters able
        // to be passed into this function and instead solely relying on the
        // addOption() method as this can then be tested.
        $options = $this->modifyOptions($options);

        $response = $this->makeRequest($verb, $path, $options);

        return $this->processResponse($response);
    }

    /**
     * @inheritdoc
     */
    public function makeRequest(string $verb, string $path, array $options = []): ResponseInterface
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

        $body_json = $response->getBody();
        $body = json_decode($body_json);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return $body_json;
        }

        if (property_exists($body, '_embedded') && property_exists($body->_embedded, 'items')) {
            return $body->_embedded->items;
        }

        if (property_exists($body, 'error') && property_exists($body, 'message')) {
            throw new ApiErrorException($body);
        }

        return $body;
    }

    /**
     * @inheritdoc
     */
    public function getQuery(): array
    {
        return $this->query;
    }

    /**
     * @inheritdoc
     */
    public function clearQuery(): void
    {
        $this->query = [];
    }

    /**
     * @inheritdoc
     */
    public function addQuery($name, $value): void
    {
        $this->query = array_merge_recursive($this->query, [$name => $value]);
    }

    /**
     * @inheritdoc
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @inheritdoc
     */
    public function clearOptions(): void
    {
        $this->options = [];
    }

    /**
     * @inheritdoc
     */
    public function addOption($name, $value): void
    {
        $this->options = array_merge_recursive($this->options, [$name => $value]);
    }
}
