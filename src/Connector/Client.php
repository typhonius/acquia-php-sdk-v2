<?php

namespace AcquiaCloudApi\Connector;

use http\Exception\RuntimeException;
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
    protected ConnectorInterface $connector;

    /**
     * @var array<string, mixed> Query strings to be applied to the request.
     */
    protected array $query = [];

    /**
     * @var array<string, mixed> Guzzle options to be applied to the request.
     */
    protected array $options = [];

    /**
     * @var array<string, mixed> Request options from each individual API call.
     */
    private array $requestOptions = [];

    /**
     * Client constructor.
     */
    final public function __construct(ConnectorInterface $connector)
    {
        $this->connector = $connector;
    }

    /**
     * Client factory method for instantiating.
     *
     * @return static
     */
    public static function factory(ConnectorInterface $connector): static
    {
        return new static(
            $connector
        );
    }

    /**
     * @inheritdoc
     */
    public function getVersion(): string
    {
        return self::VERSION;
    }

    /**
     * @inheritdoc
     */
    public function modifyOptions(): array
    {
        // Combine options set globally e.g. headers with options set by individual API calls e.g. form_params.
        $options = $this->options + $this->requestOptions;

        // This library can be standalone or as a dependency. Dependent libraries may also set their own user agent
        // which will make $options['headers']['User-Agent'] an array.
        // We need to array_unique() the array of User-Agent headers as multiple calls may include multiple of the same
        // header. We also use array_unshift() to place this library's user agent first to order to have it appear at
        // the beginning of log files.
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
    public function request(string $verb, string $path, array $options = []): mixed
    {
        // Put options sent with API calls into a property, so they can be accessed
        // and therefore tested in tests.
        $this->requestOptions = $options;

        // Modify the options to combine options set as part of the API call as well
        // as those set by tools extending this library.
        $modifiedOptions = $this->modifyOptions();

        $response = $this->makeRequest($verb, $path, $modifiedOptions);

        return $this->processResponse($response);
    }

    /**
     * @inheritdoc
     */
    public function stream(string $verb, string $path, array $options = []): StreamInterface
    {
        // Put options sent with API calls into a property so they can be accessed
        // and therefore tested in tests.
        $this->requestOptions = $options;

        // Modify the options to combine options set as part of the API call as well
        // as those set by tools extending this library.
        $modifiedOptions = $this->modifyOptions();

        return $this->makeRequest($verb, $path, $modifiedOptions)->getBody();
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
    public function processResponse(ResponseInterface $response): mixed
    {
        // Internal server errors return HTML instead of JSON, breaking our parsing.
        if ($response->getStatusCode() === 500) {
            throw new RuntimeException(
                'Cloud API internal server error. Status '
                . $response->getStatusCode()
                . '. Request ID '
                . $response->getHeaderLine('X-Request-Id')
            );
        }
        $body_json = $response->getBody();
        $body = json_decode($body_json, null, 512, JSON_THROW_ON_ERROR);
        if (is_null($body)) {
            throw new RuntimeException(
                'Response contained an empty body. Status '
                . $response->getStatusCode()
                . '. Request ID '
                . $response->getHeaderLine('X-Request-Id')
            );
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
    public function addQuery(string $name, int|string $value): void
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
    public function addOption(string $name, mixed $value): void
    {
        $this->options = array_merge_recursive($this->options, [$name => $value]);
    }
}
