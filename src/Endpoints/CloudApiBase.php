<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ConnectorInterface;
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

        if (isset($classMap[$type])) {
            return new $classMap[$type](
                $this->client->request('get', $path)
            );
        }

        throw new LinkedResourceNotImplementedException($type . ' link not implemented in this SDK. Please file an issue here: https://github.com/typhonius/acquia-php-sdk-v2/issues');
    }
}
