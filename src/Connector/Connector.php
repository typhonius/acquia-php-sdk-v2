<?php

namespace AcquiaCloudApi\Connector;

use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Token\AccessTokenInterface;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;

/**
 * Class Connector
 *
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
     * @var AccessTokenInterface|string The generated OAuth 2.0 access token.
     */
    protected $accessToken;

    /**
     * @inheritdoc
     */
    public function __construct(array $config)
    {
        $this->provider = new GenericProvider(
            [
            'clientId'                => $config['key'],
            'clientSecret'            => $config['secret'],
            'urlAuthorize'            => '',
            'urlAccessToken'          => self::URL_ACCESS_TOKEN,
            'urlResourceOwnerDetails' => '',
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function createRequest($verb, $path)
    {
        if (!isset($this->accessToken) || $this->accessToken->hasExpired()) {
            $this->accessToken = $this->provider->getAccessToken('client_credentials');
        }

        return $this->provider->getAuthenticatedRequest(
            $verb,
            self::BASE_URI . $path,
            $this->accessToken
        );
    }

    /**
     * @inheritdoc
     */
    public function sendRequest($verb, $path, $options)
    {
        $request = $this->createRequest($verb, $path);
        $client = new GuzzleClient();
        return $client->send($request, $options);
    }
}
