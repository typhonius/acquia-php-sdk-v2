<?php

namespace AcquiaCloudApi\Connector;

use AcquiaCloudApi\Connector\OktaProvider;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Token\AccessTokenInterface;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
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
    private string $baseUri;

    /**
     * @var string The URL access token for Accounts API.
     */
    private string $urlAccessToken;

    /**
     * @var string|null The Client ID.
     */
    private ?string $clientId;

    /**
     * @var GenericProvider The OAuth 2.0 provider to use in communication.
     */
    protected AbstractProvider $provider;

    /**
     * @var GuzzleClient The client used to make HTTP requests to the API.
     */
    protected GuzzleClient $client;

    /**
     * @var AccessTokenInterface|null The generated OAuth 2.0 access token.
     */
    protected ?AccessTokenInterface $accessToken;

    /**
     * @param array<string, string> $config
     */
    public function __construct(array $config, ?string $base_uri = null, ?string $url_access_token = null)
    {
        $this->baseUri = ConnectorInterface::BASE_URI;
        if ($base_uri) {
            $this->baseUri = $base_uri;
        }

        $this->urlAccessToken = ConnectorInterface::URL_ACCESS_TOKEN;
        if ($url_access_token) {
            $this->urlAccessToken = $url_access_token;
        }

        $this->clientId = $config['key'];

        $this->provider = new OktaProvider(
            [
            'clientId'                => $config['key'],
            'clientSecret'            => $config['secret'],
            'urlAuthorize'            => '',
            'urlAccessToken'          => $this->getUrlAccessToken(),
            'urlResourceOwnerDetails' => '',
            ]
        );

        $this->client = new GuzzleClient();
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function getUrlAccessToken(): string
    {
        return $this->urlAccessToken;
    }

    /**
     * @inheritdoc
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function createRequest(string $verb, string $path): RequestInterface
    {
        if (!isset($this->accessToken) || $this->accessToken->hasExpired()) {
            $xdgCacheHome = getenv('XDG_CACHE_HOME');
            if (!$xdgCacheHome) {
                $xdgCacheHome = Path::join(Path::getHomeDirectory(), '.cache');
            }
            $directory = Path::join($xdgCacheHome, 'acquia-php-sdk-v2');
            /** @infection-ignore-all */
            $cache = new FilesystemAdapter('cache', 300, $directory);
            $orgUuid = getenv('AH_ORGANIZATION_UUID');
            $cacheKey = 'cloudapi-token-' . $this->clientId . $orgUuid;
            $accessToken = $cache->get($cacheKey, function () use ($orgUuid) {
                $options = [];
                if ($orgUuid) {
                    $options['scope'] = 'organization:' . $orgUuid;
                }
                return $this->provider->getAccessToken('client_credentials', $options);
            });

            $this->accessToken = $accessToken;
        }

        return $this->provider->getAuthenticatedRequest(
            $verb,
            $this->getBaseUri() . $path,
            $this->accessToken
        );
    }

    /**
     * @inheritdoc
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function sendRequest(string $verb, string $path, array $options): ResponseInterface
    {
        $request = $this->createRequest($verb, $path);
        return $this->client->send($request, $options);
    }
}
