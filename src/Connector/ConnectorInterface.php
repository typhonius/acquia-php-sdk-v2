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
     * Creates an authenticated Request instance.
     *
     *
     */
    public function createRequest(string $verb, string $path): RequestInterface;

    /**
     * Sends the request to the API using Guzzle.
     *
     * @param array<string, array<mixed>>  $options
     *
     */
    public function sendRequest(string $verb, string $path, array $options): ResponseInterface;

    /**
     */
    public function getBaseUri(): string;

    /**
     */
    public function getUrlAccessToken(): string;
}
