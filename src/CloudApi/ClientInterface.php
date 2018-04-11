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
 * Interface ClientInterface
 *
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
     * Add a query parameter to filter results.
     *
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
     * @param string $applicationUuid
     * @return ApplicationResponse
     */
    public function application($applicationUuid);

    /**
     * Renames an application.
     *
     * @param string $applicationUuid
     * @param string $name
     * @return OperationResponse
     */
    public function renameApplication($applicationUuid, $name);

    /**
     * Shows all code branches and tags in an application.
     *
     * @param string $applicationUuid
     * @return BranchesResponse
     */
    public function code($applicationUuid);

    /**
     * Shows all databases in an application.
     *
     * @param string $applicationUuid
     * @return DatabasesResponse
     */
    public function databases($applicationUuid);

    /**
     * Shows all databases in an environment.
     *
     * @param string $environmentUuid
     * @return DatabasesResponse
     */
    public function environmentDatabases($environmentUuid);

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
     * @param string $applicationUuid
     * @param string $name
     * @return OperationResponse
     */
    public function databaseCreate($applicationUuid, $name);

    /**
     * Delete a database.
     *
     * @param string $applicationUuid
     * @param string $name
     * @return OperationResponse
     */
    public function databaseDelete($applicationUuid, $name);

    /**
     * Backup a database.
     *
     * @param string $environmentUuid
     * @param string $dbName
     * @return OperationResponse
     */
    public function createDatabaseBackup($environmentUuid, $dbName);

    /**
     * Shows all database backups in an environment.
     *
     * @param string $environmentUuid
     * @param string $dbName
     * @return BackupsResponse
     */
    public function databaseBackups($environmentUuid, $dbName);

    /**
     * Gets information about a database backup.
     *
     * @param string $environmentUuid
     * @param int    $backupId
     * @return BackupResponse
     */
    public function databaseBackup($environmentUuid, $backupId);

    /**
     * Restores a database backup to a database in an environment.
     *
     * @param string $environmentUuid
     * @param int    $backupId
     * @return OperationResponse
     */
    public function restoreDatabaseBackup($environmentUuid, $backupId);

    /**
     * Copies files from an environment to another environment.
     *
     * @param string $environmentUuidFrom
     * @param string $environmentUuidTo
     * @return OperationResponse
     */
    public function copyFiles($environmentUuidFrom, $environmentUuidTo);

    /**
     * Deploys a code branch/tag to an environment.
     *
     * @param string $environmentUuid
     * @param string $branch
     * @return OperationResponse
     */
    public function switchCode($environmentUuid, $branch);

    /**
     * Deploys code from one environment to another environment.
     *
     * @param string $environmentFromUuid
     * @param string $environmentToUuid
     * @param string $commitMessage
     * @return OperationResponse
     */
    public function deployCode($environmentUuid, $branch);

    /**
     * Shows all domains on an environment.
     *
     * @param string $environmentUuid
     * @return DomainsResponse
     */
    public function domains($environmentUuid);

    /**
     * Adds a domain to an environment.
     *
     * @param string $environmentUuid
     * @param string $hostname
     * @return OperationResponse
     */
    public function createDomain($environmentUuid, $hostname);

    /**
     * Deletes a domain from an environment.
     *
     * @param string $environmentUuid
     * @param string $domain
     * @return OperationResponse
     */
    public function deleteDomain($environmentUuid, $domain);

    /**
     * Purges varnish for selected domains in an environment.
     *
     * @param string $environmentUuid
     * @param array  $domains
     * @return OperationResponse
     */
    public function purgeVarnishCache($environmentUuid, array $domains);

    /**
     * Shows all tasks in an application.
     *
     * @param string $applicationUuid
     * @return TasksResponse
     */
    public function tasks($applicationUuid);

    /**
     * Shows all environments in an application.
     *
     * @param string $applicationUuid
     * @return EnvironmentsResponse
     */
    public function environments($applicationUuid);

    /**
     * Gets information about an environment.
     *
     * @param string $environmentUuid
     * @return EnvironmentResponse
     */
    public function environment($environmentUuid);

    /**
     * Renames an environment.
     *
     * @param string $environmentUuid
     * @param string $label
     * @return OperationResponse
     */
    public function renameEnvironment($environmentUuid, $label);

    /**
     * Show all servers associated with an environment.
     *
     * @param string $environmentUuid
     * @return ServersResponse
     */
    public function servers($environmentUuid);

    /**
     * Enable livedev mode for an environment.
     *
     * @param string $environmentUuid
     * @return OperationResponse
     */
    public function enableLiveDev($environmentUuid);

    /**
     * Disable livedev mode for an environment.
     *
     * @param string $environmentUuid
     * @return OperationResponse
     */
    public function disableLiveDev($environmentUuid);

    /**
     * Enable production mode for an environment.
     *
     * @param string $environmentUuid
     * @return OperationResponse
     */
    public function enableProductionMode($environmentUuid);

    /**
     * Disable production mode for an environment.
     *
     * @param string $environmentUuid
     * @return OperationResponse
     */
    public function disableProductionMode($environmentUuid);

    /**
     * Show all cron tasks for an environment.
     *
     * @param string $environmentUuid The environment ID
     * @return CronsResponse
     */
    public function crons($environmentUuid);

    /**
     * Get information about a cron task.
     *
     * @param string $environmentUuid The environment ID
     * @param int    $cronId
     * @return CronResponse
     */
    public function cron($environmentUuid, $cronId);

    /**
     * Add a cron task.
     *
     * @param string $environmentUuid
     * @param string $command
     * @param string $frequency
     * @param string $label
     * @return OperationResponse
     */
    public function createCron($environmentUuid, $command, $frequency, $label);

    /**
     * Delete a cron task.
     *
     * @param string $environmentUuid
     * @param int    $cronId
     * @return OperationResponse
     */
    public function deleteCron($environmentUuid, $cronId);

    /**
     * Disable a cron task.
     *
     * @param string $environmentUuid
     * @param int    $cronId
     * @return OperationResponse
     */
    public function disableCron($environmentUuid, $cronId);

    /**
     * Enable a cron task.
     *
     * @param string $environmentUuid
     * @param int    $cronId
     * @return OperationResponse
     */
    public function enableCron($environmentUuid, $cronId);

    /**
     * Provides an archived set of files for Acquia Drush aliases.
     *
     * @return StreamInterface
     */
    public function drushAliases();

    /**
     * Show insights data from an application.
     *
     * @param string $applicationUuid
     * @return InsightsResponse
     */
    public function applicationInsights($applicationUuid);

    /**
     * Show insights data from a specific environment.
     *
     * @param string $environmentUuid
     * @return InsightsResponse
     */
    public function environmentInsights($environmentUuid);

    /**
     * Show all organizations.
     *
     * @return OrganizationsResponse
     */
    public function organizations();

    /**
     * Show all applications in an organisation.
     *
     * @param string $organizationUuid
     *
     * @return ApplicationsResponse
     */
    public function organizationApplications($organizationUuid);

    /**
     * Show all roles in an organization.
     *
     * @param string $organizationUuid
     * @return RolesResponse
     */
    public function organizationRoles($organizationUuid);

    /**
     * Update the permissions associated with a role.
     *
     * @param string $roleUuid
     * @param array  $permissions
     * @return OperationResponse
     */
    public function updateRole($roleUuid, array $permissions);

    /**
     * Create a new role.
     *
     * @param string      $organizationUuid
     * @param string      $name
     * @param array       $permissions
     * @param null|string $description
     * @return OperationResponse
     */
    public function createRole($organizationUuid, $name, array $permissions, $description = null);

    /**
     * Delete a role.
     *
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
     * Rename an existing team.
     *
     * @param string $teamUuid
     * @param string $name
     * @return OperationResponse
     */
    public function renameTeam($teamUuid, $name);

    /**
     * Create a new team.
     *
     * @param string $organizationUuid
     * @param string $name
     * @return OperationResponse
     */
    public function createTeam($organizationUuid, $name);

    /**
     * Delete a team.
     *
     * @param string $teamUuid
     * @return OperationResponse
     */
    public function deleteTeam($teamUuid);

    /**
     * Add an application to a team.
     *
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
     * @param array  $roles
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
     * @return ApplicationsResponse
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
