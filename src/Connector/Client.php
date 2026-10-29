<?php

namespace AcquiaCloudApi\Connector;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\BadResponseException;
use AcquiaCloudApi\Exception\ApiErrorException;
use AcquiaCloudApi\Exception\NonJsonResponseException;
use JsonException;
use Psr\Http\Message\StreamInterface;
use RuntimeException;

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
     * @throws \AcquiaCloudApi\Exception\ApiErrorException
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
     * @throws \AcquiaCloudApi\Exception\ApiErrorException
     * @throws \RuntimeException
     */
    public function processResponse(ResponseInterface $response): mixed
    {
        $body_json = $response->getBody();
        try {
            $body = json_decode($body_json, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            // Gateways and proxies answer 502/503/504 (and sometimes 401/403)
            // with HTML or plain text; say what came back instead of where
            // json_decode() choked.
            throw new NonJsonResponseException(
                'Cloud API returned a non-JSON response. Status '
                . $response->getStatusCode()
                . ' (' . ($response->getHeaderLine('Content-Type') ?: 'no Content-Type') . ')'
                . '. ' . self::traceId($response)
                . '. Body starts with: '
                . self::excerpt($body_json),
                $response,
                $e
            );
        }
        // Internal server errors may also return a 200 response and empty body.
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
     * The id support can look a response up by.
     *
     * A response the edge synthesized (a Cloudflare 502/504, say) has no
     * X-Request-Id, because nothing upstream ever handled the request; its
     * CF-Ray is then the only trace of it.
     */
    private static function traceId(ResponseInterface $response): string
    {
        if ($id = $response->getHeaderLine('X-Request-Id')) {
            return 'Request ID ' . $id;
        }
        if ($ray = $response->getHeaderLine('CF-Ray')) {
            return 'Request ID none; CF-Ray ' . $ray;
        }
        return 'Request ID none';
    }

    /**
     * The first 200 characters of a body's visible text, for an error message.
     *
     * An HTML error page's <script> and <style> contents would otherwise fill
     * the excerpt before any readable text.
     */
    private static function excerpt(string $body): string
    {
        $text = preg_replace('#<(script|style)\b[^>]*>.*?</\1>#is', ' ', $body) ?? $body;
        // A space per tag, not strip_tags(), so "<h1>a</h1><p>b" reads "a b".
        $text = preg_replace(['/<[^>]*>/', '/\s+/'], ' ', $text) ?? $text;
        return mb_substr(trim($text), 0, 200);
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
