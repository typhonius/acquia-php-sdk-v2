<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;

/**
 * Class CloudApiBase
 *
 * @package AcquiaCloudApi\CloudApi
 */
abstract class CloudApiBase implements CloudApiInterface
{

    /**
     * @var ClientInterface The API client.
     */
    protected $client;

    /**
     * Client constructor.
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param array<string,string> $link
     * @return mixed
     */
    public function getLinkedResource($link)
    {
        $type = key($link);
        $value = reset($link);

        // Parse only the path part of the URL.
        $path = parse_url($value, PHP_URL_PATH);
        
        // Remove /api from the path as this is already added by the Connector.
        $path = substr($path, 4);

        switch($type) {
            case 'alerts':
                return new \AcquiaCloudApi\Response\InsightAlertsResponse(
                    $this->client->request('get', $path)
                );
            break;
            case 'applications':
                return new \AcquiaCloudApi\Response\ApplicationsResponse(
                    $this->client->request('get', $path)
                );
            break;
            case 'backups':
                return new \AcquiaCloudApi\Response\BackupsResponse(
                    $this->client->request('get', $path)
                );
            break;
            case 'code':
                return new \AcquiaCloudApi\Response\BranchesResponse(
                    $this->client->request('get', $path)
                );
            break;
            case 'crons':
                return new \AcquiaCloudApi\Response\CronsResponse(
                    $this->client->request('get', $path)
                );
            break;
            case 'databases':
                return new \AcquiaCloudApi\Response\DatabasesResponse(
                    $this->client->request('get', $path)
                );
            break;
            case 'domains':
                return new \AcquiaCloudApi\Response\DomainsResponse(
                    $this->client->request('get', $path)
                );
            break;
            case 'download':
            break;
            case 'environments':
                return new \AcquiaCloudApi\Response\EnvironmentsResponse(
                    $this->client->request('get', $path)
                );
            break;
            case 'events':
            break;
            case 'features':
            break;
            case 'ides':
                return new \AcquiaCloudApi\Response\IdesResponse(
                    $this->client->request('get', $path)
                );
            break;
            case 'insight':
                return new \AcquiaCloudApi\Response\InsightsResponse(
                    $this->client->request('get', $path)
                );
            break;
            case 'logs':
                return new \AcquiaCloudApi\Response\LogsResponse(
                    $this->client->request('get', $path)
                );
            break;
            case 'members':
                return new \AcquiaCloudApi\Response\MembersResponse(
                    $this->client->request('get', $path)
                );
            break;
            case 'metrics':
                return new \AcquiaCloudApi\Response\MetricsResponse(
                    $this->client->request('get', $path)
                );
            break;
            case 'modules':
                return new \AcquiaCloudApi\Response\InsightModulesResponse(
                    $this->client->request('get', $path)
                );
            break;
            case 'notification':
                return new \AcquiaCloudApi\Response\NotificationResponse(
                    $this->client->request('get', $path)
                );
            break;
            case 'permissions':
                return new \AcquiaCloudApi\Response\PermissionsResponse(
                    $this->client->request('get', $path)
                );
            break;
            case 'servers':return new \AcquiaCloudApi\Response\ServersResponse(
                $this->client->request('get', $path)
            );
            break;
            case 'settings':
            break;
            case 'ssl':
                return new \AcquiaCloudApi\Response\SslCertificatesResponse(
                    $this->client->request('get', $path)
                );
            break;
            case 'tasks':
            break;
            case 'teams':
                return new \AcquiaCloudApi\Response\TeamsResponse(
                    $this->client->request('get', $path)
                );
            break;
            case 'variables':
                return new \AcquiaCloudApi\Response\VariablesResponse(
                    $this->client->request('get', $path)
                );
            break;

        }

        var_dump(get_defined_vars());
        throw new \Exception('Not found');
    }
}
