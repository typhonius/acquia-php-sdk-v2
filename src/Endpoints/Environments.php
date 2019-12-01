<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;
use AcquiaCloudApi\Response\EnvironmentResponse;
use AcquiaCloudApi\Response\EnvironmentsResponse;
use AcquiaCloudApi\Response\DatabasesResponse;
use AcquiaCloudApi\Response\CronsResponse;
use AcquiaCloudApi\Response\CronResponse;
use AcquiaCloudApi\Response\BackupsResponse;
use AcquiaCloudApi\Response\BackupResponse;
use AcquiaCloudApi\Response\DomainsResponse;
use AcquiaCloudApi\Response\DomainResponse;
use AcquiaCloudApi\Response\InsightsResponse;
use AcquiaCloudApi\Response\ServersResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Client
 * @package AcquiaCloudApi\CloudApi
 */
class Environments implements CloudApi
{

    /** @var ClientInterface The API client. */
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
     * Shows all databases in an environment.
     *
     * @param string $environmentUuid
     * @return DatabasesResponse
     */
    public function getDatabases($environmentUuid)
    {
        return new DatabasesResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/databases"
            )
        );
    }

    /**
     * Copies a database from an environment to an environment.
     *
     * @param string $environmentFromUuid
     * @param string $dbName
     * @param string $environmentToUuid
     * @return OperationResponse
     */
    public function databaseCopy($environmentFromUuid, $dbName, $environmentToUuid)
    {
        $options = [
            'form_params' => [
                'name' => $dbName,
                'source' => $environmentFromUuid,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/environments/${environmentToUuid}/databases", $options)
        );
    }

    /**
     * Backup a database.
     *
     * @param string $environmentUuid
     * @param string $dbName
     * @return OperationResponse
     */
    public function createDatabaseBackup($environmentUuid, $dbName)
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentUuid}/databases/${dbName}/backups"
            )
        );
    }

    /**
     * Shows all database backups in an environment.
     *
     * @param string $environmentUuid
     * @param string $dbName
     * @return BackupsResponse
     */
    public function getDatabaseBackups($environmentUuid, $dbName)
    {
        return new BackupsResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/databases/${dbName}/backups"
            )
        );
    }

    /**
     * Gets information about a database backup.
     *
     * @param string $environmentUuid
     * @param string $dbName
     * @param int    $backupId
     * @return BackupResponse
     */
    public function getDatabaseBackup($environmentUuid, $dbName, $backupId)
    {
        return new BackupResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/databases/${dbName}/backups/${backupId}"
            )
        );
    }

    /**
     * Restores a database backup to a database in an environment.
     *
     * @param string $environmentUuid
     * @param string $dbName
     * @param int    $backupId
     * @return OperationResponse
     */
    public function restoreDatabaseBackup($environmentUuid, $dbName, $backupId)
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentUuid}/databases/${dbName}/backups/${backupId}/actions/restore"
            )
        );
    }

    /**
     * Copies files from an environment to another environment.
     *
     * @param string $environmentUuidFrom
     * @param string $environmentUuidTo
     * @return OperationResponse
     */
    public function copyFiles($environmentUuidFrom, $environmentUuidTo)
    {
        $options = [
            'form_params' => [
                'source' => $environmentUuidFrom,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/environments/${environmentUuidTo}/files", $options)
        );
    }

    /**
     * Deploys a code branch/tag to an environment.
     *
     * @param string $environmentUuid
     * @param string $branch
     * @return OperationResponse
     */
    public function switchCode($environmentUuid, $branch)
    {

        $options = [
            'form_params' => [
                'branch' => $branch,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentUuid}/code/actions/switch",
                $options
            )
        );
    }

    /**
     * Deploys code from one environment to another environment.
     *
     * @param string $environmentFromUuid
     * @param string $environmentToUuid
     * @param string $commitMessage
     */
    public function deployCode($environmentFromUuid, $environmentToUuid, $commitMessage = null)
    {

        $options = [
            'form_params' => [
                'source' => $environmentFromUuid,
                'message' => $commitMessage,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentToUuid}/code",
                $options
            )
        );
    }

    /**
     * Shows all domains on an environment.
     *
     * @param string $environmentUuid
     * @return DomainsResponse
     */
    public function getDomains($environmentUuid)
    {
        return new DomainsResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/domains"
            )
        );
    }

    /**
     * Return details about a domain.
     *
     * @param string $environmentUuid
     * @param string $domain
     * @return DomainResponse
     */
    public function getDomain($environmentUuid, $domain)
    {
        return new DomainResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/domains/${domain}"
            )
        );
    }

    /**
     * Adds a domain to an environment.
     *
     * @param string $environmentUuid
     * @param string $hostname
     * @return OperationResponse
     */
    public function createDomain($environmentUuid, $hostname)
    {

        $options = [
            'form_params' => [
                'hostname' => $hostname,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/environments/${environmentUuid}/domains", $options)
        );
    }

    /**
     * Deletes a domain from an environment.
     *
     * @param string $environmentUuid
     * @param string $domain
     * @return OperationResponse
     */
    public function deleteDomain($environmentUuid, $domain)
    {
        return new OperationResponse(
            $this->client->request('delete', "/environments/${environmentUuid}/domains/${domain}")
        );
    }

    /**
     * Purges varnish for selected domains in an environment.
     *
     * @param string $environmentUuid
     * @param array  $domains
     * @return OperationResponse
     */
    public function purgeVarnishCache($environmentUuid, array $domains)
    {

        $options = [
            'form_params' => [
                'domains' => $domains,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentUuid}/domains/actions/clear-varnish",
                $options
            )
        );
    }

    /**
     * Gets information about an environment.
     *
     * @param string $environmentUuid
     * @return EnvironmentResponse
     */
    public function getEnvironment($environmentUuid)
    {
        return new EnvironmentResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}"
            )
        );
    }

    /**
     * Modifies configuration settings for an environment.
     *
     * @param string $environmentUuid
     * @param array $config
     * @return OperationResponse
     */
    public function modifyEnvironment($environmentUuid, array $config)
    {

        $options = [
          'form_params' => $config,
        ];

        return new OperationResponse(
            $this->client->request(
                'put',
                "/environments/${environmentUuid}",
                $options
            )
        );
    }

    /**
     * Renames an environment.
     *
     * @param string $environmentUuid
     * @param string $label
     * @return OperationResponse
     */
    public function renameEnvironment($environmentUuid, $label)
    {

        $options = [
            'form_params' => [
                'label' => $label,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentUuid}/actions/change-label",
                $options
            )
        );
    }

    /**
     * Show all servers associated with an environment.
     *
     * @param string $environmentUuid
     * @return ServersResponse
     */
    public function getServers($environmentUuid)
    {
        return new ServersResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/servers"
            )
        );
    }

    /**
     * Enable livedev mode for an environment.
     *
     * @param string $environmentUuid
     * @return OperationResponse
     */
    public function enableLiveDev($environmentUuid)
    {
        return new OperationResponse(
            $this->client->request('post', "/environments/${environmentUuid}/livedev/actions/enable")
        );
    }

    /**
     * Disable livedev mode for an environment.
     *
     * @param string $environmentUuid
     * @return OperationResponse
     */
    public function disableLiveDev($environmentUuid)
    {

        $options = [
            'form_params' => [
                'discard' => 1,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentUuid}/livedev/actions/disable",
                $options
            )
        );
    }

    /**
     * Enable production mode for an environment.
     *
     * @param string $environmentUuid
     * @return OperationResponse
     */
    public function enableProductionMode($environmentUuid)
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentUuid}/production-mode/actions/enable"
            )
        );
    }

    /**
     * Disable production mode for an environment.
     *
     * @param string $environmentUuid
     * @return OperationResponse
     */
    public function disableProductionMode($environmentUuid)
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentUuid}/production-mode/actions/disable"
            )
        );
    }

    /**
     * Show all cron tasks for an environment.
     *
     * @param string $environmentUuid The environment ID
     * @return CronsResponse
     */
    public function getCrons($environmentUuid)
    {
        return new CronsResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/crons"
            )
        );
    }

    /**
     * Get information about a cron task.
     *
     * @param string $environmentUuid The environment ID
     * @param int    $cronId
     * @return CronResponse
     */
    public function getCron($environmentUuid, $cronId)
    {
        return new CronResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/crons/${cronId}"
            )
        );
    }

    /**
     * Add a cron task.
     *
     * @param string $environmentUuid
     * @param string $command
     * @param string $frequency
     * @param string $label
     * @return OperationResponse
     */
    public function createCron($environmentUuid, $command, $frequency, $label)
    {

        $options = [
            'form_params' => [
                'command' => $command,
                'frequency' => $frequency,
                'label' => $label,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/environments/${environmentUuid}/crons", $options)
        );
    }

    /**
     * Delete a cron task.
     *
     * @param string $environmentUuid
     * @param int    $cronId
     * @return OperationResponse
     */
    public function deleteCron($environmentUuid, $cronId)
    {
        return new OperationResponse(
            $this->client->request('delete', "/environments/${environmentUuid}/crons/${cronId}")
        );
    }

    /**
     * Disable a cron task.
     *
     * @param string $environmentUuid
     * @param int    $cronId
     * @return OperationResponse
     */
    public function disableCron($environmentUuid, $cronId)
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentUuid}/crons/${cronId}/actions/disable"
            )
        );
    }

    /**
     * Enable a cron task.
     *
     * @param string $environmentUuid
     * @param int    $cronId
     * @return OperationResponse
     */
    public function enableCron($environmentUuid, $cronId)
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentUuid}/crons/${cronId}/actions/enable"
            )
        );
    }

    /**
     * Show insights data from a specific environment.
     *
     * @param string $environmentUuid
     * @return InsightsResponse
     */
    public function getInsights($environmentUuid)
    {
        return new InsightsResponse(
            $this->client->request('get', "/environments/${environmentUuid}/insight")
        );
    }
}
