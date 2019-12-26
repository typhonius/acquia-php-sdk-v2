<?php

namespace AcquiaCloudApi\Connector;

use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\BadResponseException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;

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
     * @var string URL_ACCESS_TOKEN
     */
    const URL_ACCESS_TOKEN = 'https://accounts.acquia.com/api/auth/oauth/token';

    /**
     * @var GenericProvider The OAuth 2.0 provider to use in communication.
     */
    protected $provider;

    /**
     * @var string The generated OAuth 2.0 access token.
     */
    protected $accessToken;

    /**
     * Connector constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->provider = new GenericProvider([
            'clientId'                => $config['key'],
            'clientSecret'            => $config['secret'],
            'urlAuthorize'            => '',
            'urlAccessToken'          => self::URL_ACCESS_TOKEN,
            'urlResourceOwnerDetails' => '',
        ]);
    }

    /**
     * Creates an authenticated Request instance.
     *
     * @param string $verb
     * @param string $path
     *
     * @return RequestInterface
     */
    public function createRequest($verb, $path)
    {
        if (!isset($this->accessToken)) {
            $this->accessToken = $this->provider->getAccessToken('client_credentials');
        }

        return $this->provider->getAuthenticatedRequest(
            $verb,
            self::BASE_URI . $path,
            $this->accessToken
        );
    }

    /**
     * Sends the request to the API using Guzzle.
     *
     * @param string $verb
     * @param string $path
     * @param array $options
     *
     * @return ResponseInterface
     */
    public function sendRequest($verb, $path, $options)
    {
        $request = $this->createRequest($verb, $path);
        $client = new GuzzleClient();
        return $client->send($request, $options);
    }
}
