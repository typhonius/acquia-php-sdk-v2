<?php

namespace AcquiaCloudApi\Connector;

use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Token\AccessTokenInterface;
use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Filesystem\Path;

/**
 * Class Connector
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Connector implements ConnectorInterface
{
    /**
     * @var string The base URI for Acquia Cloud API.
     */
    protected $baseUri;

    /**
     * @var GenericProvider The OAuth 2.0 provider to use in communication.
     */
    protected $provider;

    /**
     * @var GuzzleClient The client used to make HTTP requests to the API.
     */
    protected $client;

    /**
     * @var AccessTokenInterface The generated OAuth 2.0 access token.
     */
    protected $accessToken;

    /**
     * @inheritdoc
     */
    public function __construct(array $config, string $base_uri = null)
    {
        $this->baseUri = ConnectorInterface::BASE_URI;
        if ($base_uri) {
            $this->baseUri = $base_uri;
        }

        $this->provider = new GenericProvider(
            [
            'clientId'                => $config['key'],
            'clientSecret'            => $config['secret'],
            'urlAuthorize'            => '',
            'urlAccessToken'          => self::URL_ACCESS_TOKEN,
            'urlResourceOwnerDetails' => '',
            ]
        );

        $this->client = new GuzzleClient();
    }

    /**
     * @return string
     */
    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    /**
     * @inheritdoc
     */
    public function createRequest($verb, $path)
    {
        if (!isset($this->accessToken) || $this->accessToken->hasExpired()) {
            $directory = sprintf('%s%s%s', Path::getHomeDirectory(), \DIRECTORY_SEPARATOR, '.acquia-php-sdk-v2');
            /** @infection-ignore-all */
            $cache = new FilesystemAdapter('cache', 300, $directory);
            $accessToken = $cache->get('cloudapi-token', function () {
                return $this->provider->getAccessToken('client_credentials');
            });

            $this->accessToken = $accessToken;
        }

        return $this->provider->getAuthenticatedRequest(
            $verb,
            $this->baseUri . $path,
            $this->accessToken
        );
    }

    /**
     * @inheritdoc
     */
    public function sendRequest($verb, $path, $options)
    {
        $request = $this->createRequest($verb, $path);
        return $this->client->send($request, $options);
    }
}
