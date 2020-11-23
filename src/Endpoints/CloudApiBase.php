<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;
use AcquiaCloudApi\Exception\LinkedResourceNotImplementedException;

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
     * @param array{type:string, path:string} $link
     * @return mixed
     * @throws LinkedResourceNotImplementedException
     */
    public function getLinkedResource($link)
    {
        // Remove https://cloud.acquia.com/api from the path as this is already added by the Connector.
        $path = str_replace('https://cloud.acquia.com/api', '', $link['path']);

        $type = $link['type'];

        $typeMap = [
            'alerts' => 'InsightAlertsResponse',
            'applications' => 'ApplicationsResponse',
            'backups' => 'BackupsResponse',
            'code' => 'BranchesResponse',
            'crons' => 'CronsResponse',
            'databases' => 'DatabasesResponse',
            'domains' => 'DomainsResponse',
            'environments' => 'EnvironmentsResponse',
            'ides' => 'IdesResponse',
            'insight' => 'InsightsResponse',
            'logs' => 'LogsResponse',
            'members' => 'MembersResponse',
            'metrics' => 'MetricsResponse',
            'modules' => 'InsightModulesResponse',
            'notification' => 'NotificationResponse',
            'permissions' => 'PermissionsResponse',
            'servers' => 'ServersResponse',
            'ssl' => 'SslCertificatesResponse',
            'teams' => 'TeamsResponse',
            'variables' => 'VariablesResponse',
        ];

        if (isset($typeMap[$type])) {
            $class = "\AcquiaCloudApi\Response\\${typeMap[$type]}";
            return new $class(
                $this->client->request('get', $path)
            );
        }

        throw new LinkedResourceNotImplementedException($type . ' link not implemented in this SDK. Please file an issue here: https://github.com/typhonius/acquia-php-sdk-v2/issues');
    }
}
