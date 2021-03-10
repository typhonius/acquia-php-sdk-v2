<?php

namespace AcquiaCloudApi\Connector;

use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Token\AccessTokenInterface;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;

/**
 * Interface ConnectorInterface
 *
 * @package AcquiaCloudApi\CloudApi
 */
interface ConnectorInterface
{
    /**
     * @var string BASE_URI
     */
    public const BASE_URI = 'https://cloud.acquia.com/api';

    /**
     * @var string URL_ACCESS_TOKEN
     */
    public const URL_ACCESS_TOKEN = 'https://accounts.acquia.com/api/auth/oauth/token';

    /**
     * Connector constructor.
     *
     * @param array<string, string> $config
     */
    public function __construct(array $config);

    /**
     * Creates an authenticated Request instance.
     *
     * @param string $verb
     * @param string $path
     *
     * @return RequestInterface
     */
    public function createRequest($verb, $path);

    /**
     * Sends the request to the API using Guzzle.
     *
     * @param string $verb
     * @param string $path
     * @param array<string, array>  $options
     *
     * @return ResponseInterface
     */
    public function sendRequest($verb, $path, $options);

    /**
     * @return string
     */
    public function getBaseUri(): string;
}
