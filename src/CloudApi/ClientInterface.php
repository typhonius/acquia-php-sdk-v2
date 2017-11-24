<?php

namespace AcquiaCloudApi\CloudApi;

use AcquiaCloudApi\Response\ApplicationResponse;
use AcquiaCloudApi\Response\ApplicationsResponse;
use AcquiaCloudApi\Response\BackupResponse;
use AcquiaCloudApi\Response\BackupsResponse;
use AcquiaCloudApi\Response\BranchesResponse;
use AcquiaCloudApi\Response\CronResponse;
use AcquiaCloudApi\Response\CronsResponse;
use AcquiaCloudApi\Response\DatabasesResponse;
use AcquiaCloudApi\Response\DomainsResponse;
use AcquiaCloudApi\Response\EnvironmentResponse;
use AcquiaCloudApi\Response\EnvironmentsResponse;
use AcquiaCloudApi\Response\InsightsResponse;
use AcquiaCloudApi\Response\InvitationsResponse;
use AcquiaCloudApi\Response\MembersResponse;
use AcquiaCloudApi\Response\OperationResponse;
use AcquiaCloudApi\Response\OrganizationsResponse;
use AcquiaCloudApi\Response\PermissionsResponse;
use AcquiaCloudApi\Response\RolesResponse;
use AcquiaCloudApi\Response\ServersResponse;
use AcquiaCloudApi\Response\TasksResponse;
use AcquiaCloudApi\Response\TeamsResponse;
use Psr\Http\Message\StreamInterface;

/**
 * Class Client
 * @package AcquiaCloudApi\CloudApi
 */
interface ClientInterface
{
    /**
     * Get query from Client.
     *
     * @return array
     */
    public function getQuery();

    /**
     * Clear query.
     */
    public function clearQuery();

    /**
     * @param string $name
     * @param string $value
     */
    public function addQuery($name, $value);

    /**
     * Shows all applications.
     *
     * @return ApplicationsResponse
     */
    public function applications();

    /**
     * Shows information about an application.
     *
     * @param string $uuid
     * @return ApplicationResponse
     */
    public function application($uuid);

    /**
     * Renames an application.
     *
     * @param string $uuid
     * @param string $name
     * @return OperationResponse
     */
    public function renameApplication($uuid, $name);

    /**
     * Shows all code branches and tags in an application.
     *
     * @param string $uuid
     * @return BranchesResponse
     */
    public function code($uuid);

    /**
     * Shows all databases in an application.
     *
     * @param string $uuid
     * @return DatabasesResponse
     */
    public function databases($uuid);

    /**
     * Shows all databases in an environment.
     *
     * @param string $id
     * @return DatabasesResponse
     */
    public function environmentDatabases($id);

    /**
     * Copies a database from an environment to an environment.
     *
     * @param string $environmentFromUuid
     * @param string $dbName
     * @param string $environmentToUuid
     * @return OperationResponse
     */
    public function databaseCopy($environmentFromUuid, $dbName, $environmentToUuid);

    /**
     * Create a new database.
     *
     * @param string $uuid
     * @param string $name
     * @return OperationResponse
     */
    public function databaseCreate($uuid, $name);

    /**
     * Delete a database.
     *
     * @param string $uuid
     * @param string $name
     * @return OperationResponse
     */
    public function databaseDelete($uuid, $name);

    /**
     * Backup a database.
     *
     * @param string $id
     * @param string $dbName
     * @return OperationResponse
     */
    public function createDatabaseBackup($id, $dbName);

    /**
     * Shows all database backups in an environment.
     *
     * @param string $id
     * @param string $dbName
     * @return BackupsResponse
     */
    public function databaseBackups($id, $dbName);

    /**
     * Gets information about a database backup.
     *
     * @param string $id
     * @param string $backupId
     * @return BackupResponse
     */
    public function databaseBackup($id, $backupId);

    /**
     * Restores a database backup to a database in an environment.
     *
     * @param string $id
     * @param string $backupId
     * @return OperationResponse
     */
    public function restoreDatabaseBackup($id, $backupId);

    /**
     * Copies files from an environment to another environment.
     *
     * @param string $idFrom
     * @param string $idTo
     * @return OperationResponse
     */
    public function copyFiles($idFrom, $idTo);

    /**
     * Deploys a code branch/tag to an environment.
     *
     * @param string $id
     * @param string $branch
     * @return OperationResponse
     */
    public function switchCode($id, $branch);

    /**
     * Shows all domains on an environment.
     *
     * @param string $id
     * @return DomainsResponse
     */
    public function domains($id);

    /**
     * Adds a domain to an environment.
     *
     * @param string $id
     * @param string $hostname
     * @return OperationResponse
     */
    public function createDomain($id, $hostname);

    /**
     * Deletes a domain from an environment.
     *
     * @param string $id
     * @param string $domain
     * @return OperationResponse
     */
    public function deleteDomain($id, $domain);

    /**
     * Purges varnish for selected domains in an environment.
     *
     * @param string $id
     * @param array $domains
     * @return OperationResponse
     */
    public function purgeVarnishCache($id, array $domains);

    /**
     * Shows all tasks in an application.
     *
     * @param string $uuid
     * @return TasksResponse
     */
    public function tasks($uuid);

    /**
     * Shows all environments in an application.
     *
     * @param string $uuid
     * @return EnvironmentsResponse
     */
    public function environments($uuid);

    /**
     * Gets information about an environment.
     *
     * @param string $id
     * @return EnvironmentResponse
     */
    public function environment($id);

    /**
     * Renames an environment.
     *
     * @param string $id
     * @param string $label
     * @return OperationResponse
     */
    public function renameEnvironment($id, $label);

    /**
     * Show all servers associated with an environment.
     *
     * @param string $id
     * @return ServersResponse
     */
    public function servers($id);

    /**
     * Enable livedev mode for an environment.
     *
     * @param string $id
     * @return OperationResponse
     */
    public function enableLiveDev($id);

    /**
     * Disable livedev mode for an environment.
     *
     * @param string $id
     * @return OperationResponse
     */
    public function disableLiveDev($id);

    /**
     * Enable production mode for an environment.
     *
     * @param string $id
     * @return OperationResponse
     */
    public function enableProductionMode($id);

    /**
     * Disable production mode for an environment.
     *
     * @param string $id
     * @return OperationResponse
     */
    public function disableProductionMode($id);

    /**
     * Show all cron tasks for an environment.
     *
     * @param string $id The environment ID
     * @return CronsResponse
     */
    public function crons($id);

    /**
     * Get information about a cron task.
     *
     * @param string $id The environment ID
     * @param int $cronId
     * @return CronResponse
     */
    public function cron($id, $cronId);

    /**
     * Add a cron task.
     *
     * @param string $id
     * @param string $command
     * @param string $frequency
     * @param string $label
     * @return OperationResponse
     */
    public function createCron($id, $command, $frequency, $label);

    /**
     * Delete a cron task.
     *
     * @param string $id
     * @param int $cronId
     * @return OperationResponse
     */
    public function deleteCron($id, $cronId);

    /**
     * Disable a cron task.
     *
     * @param string $id
     * @param int $cronId
     * @return OperationResponse
     */
    public function disableCron($id, $cronId);

    /**
     * Enable a cron task.
     *
     * @param string $id
     * @param int $cronId
     * @return OperationResponse
     */
    public function enableCron($id, $cronId);

    /**
     * @return StreamInterface
     */
    public function drushAliases();

    /**
     * Show insights data from an application.
     *
     * @param string $uuid
     * @return InsightsResponse
     */
    public function applicationInsights($uuid);

    /**
     * Show insights data from a specific environment.
     *
     * @param string $id
     * @return InsightsResponse
     */
    public function environmentInsights($id);

    /**
     * Show all organizations.
     *
     * @return OrganizationsResponse
     */
    public function organizations();

    /**
     * Show all applications in an organisation.
     *
     * @param string $uuid
     *
     * @return ApplicationsResponse
     */
    public function organizationApplications($uuid);

    /**
     * Show all roles in an organization.
     *
     * @param string $uuid
     * @return RolesResponse
     */
    public function organizationRoles($uuid);

    /**
     * @param string $roleUuid
     * @param array $permissions
     * @return OperationResponse
     */
    public function updateRole($roleUuid, array $permissions);

    /**
     * @param string $uuid
     * @param string $name
     * @param array $permissions
     * @param null|string $description
     * @return OperationResponse
     */
    public function createRole($uuid, $name, array $permissions, $description = null);

    /**
     * @param string $roleUuid
     * @return OperationResponse
     */
    public function deleteRole($roleUuid);

    /**
     * Show all teams in an organization.
     *
     * @param string $organizationUuid
     * @return TeamsResponse
     */
    public function organizationTeams($organizationUuid);

    /**
     * Show all teams.
     *
     * @return TeamsResponse
     */
    public function teams();

    /**
     * @param string $teamUuid
     * @param string $name
     * @return OperationResponse
     */
    public function renameTeam($teamUuid, $name);

    /**
     * Create a new team.
     *
     * @param string $uuid
     * @param string $name
     * @return OperationResponse
     */
    public function createTeam($uuid, $name);

    /**
     * @param string $teamUuid
     * @return OperationResponse
     */
    public function deleteTeam($teamUuid);

    /**
     * @param string $teamUuid
     * @param string $applicationUuid
     * @return OperationResponse
     */
    public function addApplicationToTeam($teamUuid, $applicationUuid);

    /**
     * Invites a user to join a team.
     *
     * @param string $teamUuid
     * @param string $email
     * @param array $roles
     * @return OperationResponse
     */
    public function createTeamInvite($teamUuid, $email, $roles);

    /**
     * Invites a user to become admin of an organization.
     *
     * @param string $organizationUuid
     * @param string $email
     * @return OperationResponse
     */
    public function createOrganizationAdminInvite($organizationUuid, $email);

    /**
     * Show all applications associated with a team.
     *
     * @param string $teamUuid
     * @return ApplicationResponse
     */
    public function teamApplications($teamUuid);

    /**
     * Show all members of an organisation.
     *
     * @param string $organizationUuid
     * @return MembersResponse
     */
    public function members($organizationUuid);

    /**
     * Show all members invited to an organisation.
     *
     * @param string $organizationUuid
     * @return InvitationsResponse
     */
    public function invitees($organizationUuid);

    /**
     * Delete a member from an organisation.
     *
     * @param string $organizationUuid
     * @param string $memberUuid
     * @return OperationResponse
     */
    public function deleteMember($organizationUuid, $memberUuid);

    /**
     * Show all available permissions.
     *
     * @return PermissionsResponse
     */
    public function permissions();
}
