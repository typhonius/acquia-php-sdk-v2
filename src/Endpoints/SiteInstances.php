<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\BackupResponse;
use AcquiaCloudApi\Response\BackupsResponse;
use AcquiaCloudApi\Response\DomainResponse;
use AcquiaCloudApi\Response\DomainsResponse;
use AcquiaCloudApi\Response\OperationResponse;
use AcquiaCloudApi\Response\SiteInstanceResponse;
use AcquiaCloudApi\Response\SiteInstanceDatabaseResponse;

/**
 * Class SiteInstances
 *
 * @package AcquiaCloudApi\CloudApi
 */
class SiteInstances extends CloudApiBase
{
    /**
     * Returns details about a specific site instance.
     */
    public function get(string $siteId, string $environmentId): SiteInstanceResponse
    {
        return new SiteInstanceResponse(
            $this->client->request(
                'get',
                "/site-instances/$siteId.$environmentId"
            )
        );
    }

    /**
     * Returns database details for a site instance.
     */
    public function getDatabase(string $siteId, string $environmentId): SiteInstanceDatabaseResponse
    {
        return new SiteInstanceDatabaseResponse(
            $this->client->request(
                'get',
                "/site-instances/$siteId.$environmentId/database"
            )
        );
    }

    /**
     * Copies database from source environment to target environment.
     */
    public function copyDatabase(string $siteId, string $environmentId, string $sourceEnvironmentId): OperationResponse
    {
        $options = [
            'json' => [
                'source' => $sourceEnvironmentId,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'post',
                "/site-instances/$siteId.$environmentId/database",
                $options
            )
        );
    }

    /**
     * Returns a list of database backups for a site instance.
     *
     * @return BackupsResponse<BackupResponse>
     */
    public function getDatabaseBackups(string $siteId, string $environmentId): BackupsResponse
    {
        return new BackupsResponse(
            $this->client->request(
                'get',
                "/site-instances/$siteId.$environmentId/database/backups"
            )
        );
    }

    /**
     * Creates a database backup for a site instance.
     */
    public function createDatabaseBackup(string $siteId, string $environmentId): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/site-instances/$siteId.$environmentId/database/backups"
            )
        );
    }

    /**
     * Returns details about a specific database backup.
     */
    public function getDatabaseBackup(string $siteId, string $environmentId, string $backupId): BackupResponse
    {
        return new BackupResponse(
            $this->client->request(
                'get',
                "/site-instances/$siteId.$environmentId/database/backups/$backupId"
            )
        );
    }

    /**
     * Downloads a database backup.
     */
    public function downloadDatabaseBackup(string $siteId, string $environmentId, string $backupId): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'get',
                "/site-instances/$siteId.$environmentId/database/backups/$backupId/actions/download"
            )
        );
    }

    /**
     * Restores a database backup.
     */
    public function restoreDatabaseBackup(string $siteId, string $environmentId, string $backupId): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/site-instances/$siteId.$environmentId/database/backups/$backupId/actions/restore"
            )
        );
    }

    /**
     * Returns a list of domains for a site instance.
     *
     * @return DomainsResponse<DomainResponse>
     */
    public function getDomains(string $siteId, string $environmentId): DomainsResponse
    {
        return new DomainsResponse(
            $this->client->request(
                'get',
                "/site-instances/$siteId.$environmentId/domains"
            )
        );
    }

    /**
     * Returns details about a specific domain for a site instance.
     */
    public function getDomain(string $siteId, string $environmentId, string $domainName): DomainResponse
    {
        return new DomainResponse(
            $this->client->request(
                'get',
                "/site-instances/$siteId.$environmentId/domains/$domainName"
            )
        );
    }

    /**
     * Returns the status of a specific domain for a site instance.
     */
    public function getDomainStatus(string $siteId, string $environmentId, string $domainName): DomainResponse
    {
        return new DomainResponse(
            $this->client->request(
                'get',
                "/site-instances/$siteId.$environmentId/domains/$domainName/status"
            )
        );
    }

    /**
     * Copies files from source environment to target environment.
     */
    public function copyFiles(string $siteId, string $environmentId, string $sourceEnvironmentId): OperationResponse
    {
        $options = [
            'json' => [
                'source' => $sourceEnvironmentId,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'post',
                "/site-instances/$siteId.$environmentId/files",
                $options
            )
        );
    }
}
