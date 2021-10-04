<?php

namespace AcquiaCloudApi\Connector;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\BadResponseException;
use AcquiaCloudApi\Exception\ApiErrorException;
use Psr\Http\Message\StreamInterface;
use AcquiaCloudApi\Exception\LinkedResourceNotImplementedException;

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
     * @var array<string, mixed> Query strings to be applied to the request.
     */
    protected $query = [];

    /**
     * @var array<string, mixed> Guzzle options to be applied to the request.
     */
    protected $options = [];

    /**
     * @var array<string, mixed> Request options from each individual API call.
     */
    private $requestOptions = [];

    /**
     * Client constructor.
     *
     * @param ConnectorInterface $connector
     */
    final public function __construct(ConnectorInterface $connector)
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
        // Put options sent with API calls into a property so they can be accessed
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
    public function stream(string $verb, string $path, array $options = [])
    {
        // Put options sent with API calls into a property so they can be accessed
        // and therefore tested in tests.
        $this->requestOptions = $options;

        // Modify the options to combine options set as part of the API call as well
        // as those set by tools extending this library.
        $modifiedOptions = $this->modifyOptions();

        $response = $this->makeRequest($verb, $path, $modifiedOptions);

        return $response->getBody();
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

    /**
     * @param array{type:string, path:string, responseClass:class-string} $link
     * @return mixed
     * @throws LinkedResourceNotImplementedException
     */
    public function getLinkedResource($link)
    {
        // Remove the base URI from the path as this is already added by the Connector when we call request().
        $path = str_replace(ConnectorInterface::BASE_URI, '', $link['path']);
        $type = $link['type'];
        $responseClass = $link['responseClass'];

        $classMap = [
            'alerts' => '\AcquiaCloudApi\Response\InsightAlertsResponse',
            'applications' => '\AcquiaCloudApi\Response\ApplicationsResponse',
            'backups' => '\AcquiaCloudApi\Response\BackupsResponse',
            'code' => '\AcquiaCloudApi\Response\BranchesResponse',
            'crons' => '\AcquiaCloudApi\Response\CronsResponse',
            'databases' => '\AcquiaCloudApi\Response\DatabasesResponse',
            'domains' => '\AcquiaCloudApi\Response\DomainsResponse',
            'environments' => '\AcquiaCloudApi\Response\EnvironmentsResponse',
            'ides' => '\AcquiaCloudApi\Response\IdesResponse',
            'insight' => '\AcquiaCloudApi\Response\InsightsResponse',
            'logs' => '\AcquiaCloudApi\Response\LogsResponse',
            'members' => '\AcquiaCloudApi\Response\MembersResponse',
            'metrics' => '\AcquiaCloudApi\Response\MetricsResponse',
            'modules' => '\AcquiaCloudApi\Response\InsightModulesResponse',
            'notification' => '\AcquiaCloudApi\Response\NotificationResponse',
            'permissions' => '\AcquiaCloudApi\Response\PermissionsResponse',
            'self' => $responseClass,
            'servers' => '\AcquiaCloudApi\Response\ServersResponse',
            'ssl' => '\AcquiaCloudApi\Response\SslCertificatesResponse',
            'teams' => '\AcquiaCloudApi\Response\TeamsResponse',
            'variables' => '\AcquiaCloudApi\Response\VariablesResponse',
        ];

        // Clear any queries attached to the client to prevent sorts etc being carried through
        // from the original query.
        // @TODO this may need to be removed if users wish to filter/sort linked resources.
        $this->clearQuery();

        if (isset($classMap[$type])) {
            return new $classMap[$type](
                $this->request('get', $path)
            );
        }

        throw new LinkedResourceNotImplementedException($type . ' link not implemented in this SDK. Please file an issue here: https://github.com/typhonius/acquia-php-sdk-v2/issues');
    }
}
