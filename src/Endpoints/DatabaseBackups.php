<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\BackupResponse;
use AcquiaCloudApi\Response\BackupsResponse;
use AcquiaCloudApi\Response\OperationResponse;
use Psr\Http\Message\StreamInterface;

/**
 * Class DatabaseBackups
 *
 * @package AcquiaCloudApi\CloudApi
 */
class DatabaseBackups extends CloudApiBase
{
    /**
     * Backup a database.
     */
    public function create(string $environmentUuid, string $dbName): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/$environmentUuid/databases/$dbName/backups"
            )
        );
    }

    /**
     * Shows all database backups in an environment.
     *
     * @return BackupsResponse<BackupResponse>
     */
    public function getAll(string $environmentUuid, string $dbName): BackupsResponse
    {
        return new BackupsResponse(
            $this->client->request(
                'get',
                "/environments/$environmentUuid/databases/$dbName/backups"
            )
        );
    }

    /**
     * Gets information about a database backup.
     */
    public function get(string $environmentUuid, string $dbName, int $backupId): BackupResponse
    {
        return new BackupResponse(
            $this->client->request(
                'get',
                "/environments/$environmentUuid/databases/$dbName/backups/$backupId"
            )
        );
    }

    /**
     * Restores a database backup to a database in an environment.
     */
    public function restore(string $environmentUuid, string $dbName, int $backupId): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/$environmentUuid/databases/$dbName/backups/$backupId/actions/restore"
            )
        );
    }

    /**
     * Downloads a database backup.
     */
    public function download(string $environmentUuid, string $dbName, int $backupId): StreamInterface
    {
        return $this->client->stream(
            'get',
            "/environments/$environmentUuid/databases/$dbName/backups/$backupId/actions/download"
        );
    }

    /**
     * Deletes a database backup.
     */
    public function delete(string $environmentUuid, string $dbName, int $backupId): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'delete',
                "/environments/$environmentUuid/databases/$dbName/backups/$backupId"
            )
        );
    }
}
