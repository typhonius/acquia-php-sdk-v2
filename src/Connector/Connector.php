<?php

namespace AcquiaCloudApi\Connector;

use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Token\AccessTokenInterface;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;
use Webmozart\PathUtil\Path;

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
    public function __construct(array $config)
    {
        $this->baseUri = ConnectorInterface::BASE_URI;
        if (getenv('ACQUIA_CLOUD_API_BASE_URI')) {
            $this->baseUri = getenv('ACQUIA_CLOUD_API_BASE_URI');
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
     * @inheritdoc
     */
    public function createRequest($verb, $path)
    {
        if (!isset($this->accessToken) || $this->accessToken->hasExpired()) {
            $directory = sprintf('%s%s%s', Path::getHomeDirectory(), \DIRECTORY_SEPARATOR, '.acquia-php-sdk-v2');
            $cache = new FilesystemAdapter('cache', 300, $directory);
            $accessToken = $cache->get('cloudapi-token', function () {
                return $this->provider->getAccessToken('client_credentials');
            });

            $this->accessToken = $accessToken;
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
        return $this->client->send($request, $options);
    }
}
