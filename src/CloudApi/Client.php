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
class Client implements ClientInterface
{
    /** @var ConnectorInterface The API connector. */
    protected $connector;

    /** @var array Query strings to be applied to the request. */
    protected $query = [];

    /**
     * Client constructor.
     *
     * @param ConnectorInterface $connector
     */
    public function __construct(ConnectorInterface $connector)
    {
        $this->connector = $connector;
    }

    /**
     * Client factory method for instantiating .
     *
     * @param ConnectorInterface $connector
     *
     * @return static
     */
    public static function factory(ConnectorInterface $connector)
    {
        $client = new static(
            $connector
        );

        return $client;
    }

    /**
     * Get query from Client.
     *
     * @return array
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Clear query.
     */
    public function clearQuery()
    {
        $this->query = [];
    }

    /**
     * Add a query parameter to filter results.
     *
     * @param string $name
     * @param string $value
     */
    public function addQuery($name, $value)
    {
        $this->query = array_merge_recursive($this->query, [$name => $value]);
    }

    /**
     * Shows all applications.
     *
     * @return ApplicationsResponse
     */
    public function applications()
    {
        return new ApplicationsResponse($this->connector->request('get', '/applications', $this->query));
    }

    /**
     * Shows information about an application.
     *
     * @param string $applicationUuid
     * @return ApplicationResponse
     */
    public function application($applicationUuid)
    {
        return new ApplicationResponse(
            $this->connector->request(
                'get',
                "/applications/${applicationUuid}",
                $this->query
            )
        );
    }

    /**
     * Renames an application.
     *
     * @param string $applicationUuid
     * @param string $name
     * @return OperationResponse
     */
    public function renameApplication($applicationUuid, $name)
    {

        $options = [
            'form_params' => [
                'name' => $name,
            ],
        ];

        return new OperationResponse(
            $this->connector->request(
                'put',
                "/applications/${applicationUuid}",
                $options,
                $this->query
            )
        );
    }

    /**
     * Shows all code branches and tags in an application.
     *
     * @param string $applicationUuid
     * @return BranchesResponse
     */
    public function code($applicationUuid)
    {
        return new BranchesResponse(
            $this->connector->request(
                'get',
                "/applications/${applicationUuid}/code",
                $this->query
            )
        );
    }

    /**
     * Shows all databases in an application.
     *
     * @param string $applicationUuid
     * @return DatabasesResponse
     */
    public function databases($applicationUuid)
    {
        return new DatabasesResponse(
            $this->connector->request(
                'get',
                "/applications/${applicationUuid}/databases",
                $this->query
            )
        );
    }

    /**
     * Shows all databases in an environment.
     *
     * @param string $environmentUuid
     * @return DatabasesResponse
     */
    public function environmentDatabases($environmentUuid)
    {
        return new DatabasesResponse(
            $this->connector->request(
                'get',
                "/environments/${environmentUuid}/databases",
                $this->query
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
            $this->connector->request('post', "/environments/${environmentToUuid}/databases", $this->query, $options)
        );
    }

    /**
     * Create a new database.
     *
     * @param string $applicationUuid
     * @param string $name
     * @return OperationResponse
     */
    public function databaseCreate($applicationUuid, $name)
    {
        $options = [
            'form_params' => [
                'name' => $name,
            ],
        ];

        return new OperationResponse(
            $this->connector->request('post', "/applications/${applicationUuid}/databases", $this->query, $options)
        );
    }

    /**
     * Delete a database.
     *
     * @param string $applicationUuid
     * @param string $name
     * @return OperationResponse
     */
    public function databaseDelete($applicationUuid, $name)
    {
        return new OperationResponse(
            $this->connector->request('post', "/applications/${applicationUuid}/databases/${name}", $this->query)
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
            $this->connector->request(
                'post',
                "/environments/${environmentUuid}/databases/${dbName}/backups",
                $this->query
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
    public function databaseBackups($environmentUuid, $dbName)
    {
        return new BackupsResponse(
            $this->connector->request(
                'get',
                "/environments/${environmentUuid}/databases/${dbName}/backups",
                $this->query
            )
        );
    }

    /**
     * Gets information about a database backup.
     *
     * @param string $environmentUuid
     * @param int    $backupId
     * @return BackupResponse
     */
    public function databaseBackup($environmentUuid, $backupId)
    {
        return new BackupResponse(
            $this->connector->request(
                'get',
                "/environments/${environmentUuid}/database-backups/${backupId}",
                $this->query
            )
        );
    }

    /**
     * Restores a database backup to a database in an environment.
     *
     * @param string $environmentUuid
     * @param int    $backupId
     * @return OperationResponse
     */
    public function restoreDatabaseBackup($environmentUuid, $backupId)
    {
        return new OperationResponse(
            $this->connector->request(
                'post',
                "/environments/${environmentUuid}/database-backups/${backupId}/actions/restore",
                $this->query
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
            $this->connector->request('post', "/environments/${environmentUuidTo}/files", $this->query, $options)
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
            $this->connector->request(
                'post',
                "/environments/${environmentUuid}/code/actions/switch",
                $this->query,
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
            $this->connector->request(
                'post',
                "/environments/${environmentToUuid}/code",
                $this->query,
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
    public function domains($environmentUuid)
    {
        return new DomainsResponse(
            $this->connector->request(
                'get',
                "/environments/${environmentUuid}/domains",
                $this->query
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
            $this->connector->request('post', "/environments/${environmentUuid}/domains", $this->query, $options)
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
            $this->connector->request('delete', "/environments/${environmentUuid}/domains/${domain}", $this->query)
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
            $this->connector->request(
                'post',
                "/environments/${environmentUuid}/domains/actions/clear-varnish",
                $this->query,
                $options
            )
        );
    }

    /**
     * Shows all tasks in an application.
     *
     * @param string $applicationUuid
     * @return TasksResponse
     */
    public function tasks($applicationUuid)
    {
        return new TasksResponse(
            $this->connector->request(
                'get',
                "/applications/${applicationUuid}/tasks",
                $this->query
            )
        );
    }

    /**
     * Shows all environments in an application.
     *
     * @param string $applicationUuid
     * @return EnvironmentsResponse
     */
    public function environments($applicationUuid)
    {
        return new EnvironmentsResponse(
            $this->connector->request(
                'get',
                "/applications/${applicationUuid}/environments",
                $this->query
            )
        );
    }

    /**
     * Gets information about an environment.
     *
     * @param string $environmentUuid
     * @return EnvironmentResponse
     */
    public function environment($environmentUuid)
    {
        return new EnvironmentResponse(
            $this->connector->request(
                'get',
                "/environments/${environmentUuid}",
                $this->query
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
            $this->connector->request(
                'post',
                "/environments/${environmentUuid}/actions/change-label",
                $this->query,
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
    public function servers($environmentUuid)
    {
        return new ServersResponse(
            $this->connector->request(
                'get',
                "/environments/${environmentUuid}/servers",
                $this->query
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
            $this->connector->request('post', "/environments/${environmentUuid}/livedev/actions/enable", $this->query)
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
            $this->connector->request(
                'post',
                "/environments/${environmentUuid}/livedev/actions/disable",
                $this->query,
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
            $this->connector->request(
                'post',
                "/environments/${environmentUuid}/production-mode/actions/enable",
                $this->query
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
            $this->connector->request(
                'post',
                "/environments/${environmentUuid}/production-mode/actions/disable",
                $this->query
            )
        );
    }

    /**
     * Show all cron tasks for an environment.
     *
     * @param string $environmentUuid The environment ID
     * @return CronsResponse
     */
    public function crons($environmentUuid)
    {
        return new CronsResponse(
            $this->connector->request(
                'get',
                "/environments/${environmentUuid}/crons",
                $this->query
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
    public function cron($environmentUuid, $cronId)
    {
        return new CronResponse(
            $this->connector->request(
                'get',
                "/environments/${environmentUuid}/crons/${cronId}",
                $this->query
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
            $this->connector->request('post', "/environments/${environmentUuid}/crons", $this->query, $options)
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
            $this->connector->request('delete', "/environments/${environmentUuid}/crons/${cronId}", $this->query)
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
            $this->connector->request(
                'post',
                "/environments/${environmentUuid}/crons/${cronId}/actions/disable",
                $this->query
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
            $this->connector->request(
                'post',
                "/environments/${environmentUuid}/crons/${cronId}/actions/enable",
                $this->query
            )
        );
    }

    /**
     * Provides an archived set of files for Acquia Drush aliases.
     *
     * @return StreamInterface
     */
    public function drushAliases()
    {
        return $this->connector->request('get', '/account/drush-aliases/download', $this->query);
    }

    /**
     * Show insights data from an application.
     *
     * @param string $applicationUuid
     * @return InsightsResponse
     */
    public function applicationInsights($applicationUuid)
    {
        return new InsightsResponse(
            $this->connector->request('get', "/applications/${applicationUuid}/insight", $this->query)
        );
    }

    /**
     * Show insights data from a specific environment.
     *
     * @param string $environmentUuid
     * @return InsightsResponse
     */
    public function environmentInsights($environmentUuid)
    {
        return new InsightsResponse(
            $this->connector->request('get', "/environments/${environmentUuid}/insight", $this->query)
        );
    }

    /**
     * Show all organizations.
     *
     * @return OrganizationsResponse
     */
    public function organizations()
    {
        return new OrganizationsResponse($this->connector->request('get', '/organizations', $this->query));
    }

    /**
     * Show all applications in an organisation.
     *
     * @param string $organizationUuid
     *
     * @return ApplicationsResponse
     */
    public function organizationApplications($organizationUuid)
    {
        return new ApplicationsResponse(
            $this->connector->request('get', "/organizations/${organizationUuid}/applications", $this->query)
        );
    }

    /**
     * Show all roles in an organization.
     *
     * @param string $organizationUuid
     * @return RolesResponse
     */
    public function organizationRoles($organizationUuid)
    {
        return new RolesResponse(
            $this->connector->request('get', "/organizations/${organizationUuid}/roles", $this->query)
        );
    }

    /**
     * Update the permissions associated with a role.
     *
     * @param string $roleUuid
     * @param array  $permissions
     * @return OperationResponse
     */
    public function updateRole($roleUuid, array $permissions)
    {
        $options = [
            'form_params' => [
                'permissions' => $permissions,
            ],
        ];

        return new OperationResponse(
            $this->connector->request('put', "/roles/${roleUuid}", $this->query, $options)
        );
    }

    /**
     * Create a new role.
     *
     * @param string      $organizationUuid
     * @param string      $name
     * @param array       $permissions
     * @param null|string $description
     * @return OperationResponse
     */
    public function createRole($organizationUuid, $name, array $permissions, $description = null)
    {
        $options = [
            'form_params' => [
                'name' => $name,
                'permissions' => $permissions,
                'description' => $description,
            ],
        ];

        return new OperationResponse(
            $this->connector->request('post', "/organizations/${organizationUuid}/roles", $this->query, $options)
        );
    }

    /**
     * Delete a role.
     *
     * @param string $roleUuid
     * @return OperationResponse
     */
    public function deleteRole($roleUuid)
    {
        return new OperationResponse($this->connector->request('delete', "/roles/${roleUuid}", $this->query));
    }

    /**
     * Show all teams in an organization.
     *
     * @param string $organizationUuid
     * @return TeamsResponse
     */
    public function organizationTeams($organizationUuid)
    {
        return new TeamsResponse(
            $this->connector->request('get', "/organizations/${organizationUuid}/teams", $this->query)
        );
    }

    /**
     * Show all teams.
     *
     * @return TeamsResponse
     */
    public function teams()
    {
        return new TeamsResponse(
            $this->connector->request('get', '/teams', $this->query)
        );
    }

    /**
     * Rename an existing team.
     *
     * @param string $teamUuid
     * @param string $name
     * @return OperationResponse
     */
    public function renameTeam($teamUuid, $name)
    {
        $options = [
            'form_params' => [
                'name' => $name,
            ],
        ];

        return new OperationResponse(
            $this->connector->request('put', "/teams/${teamUuid}", $options)
        );
    }

    /**
     * Create a new team.
     *
     * @param string $organizationUuid
     * @param string $name
     * @return OperationResponse
     */
    public function createTeam($organizationUuid, $name)
    {
        $options = [
            'form_params' => [
                'name' => $name,
            ],
        ];

        return new OperationResponse(
            $this->connector->request('post', "/organizations/${organizationUuid}/teams", $this->query, $options)
        );
    }

    /**
     * Delete a team.
     *
     * @param string $teamUuid
     * @return OperationResponse
     */
    public function deleteTeam($teamUuid)
    {
        return new OperationResponse(
            $this->connector->request('delete', "/teams/${teamUuid}", $this->query)
        );
    }

    /**
     * Add an application to a team.
     *
     * @param string $teamUuid
     * @param string $applicationUuid
     * @return OperationResponse
     */
    public function addApplicationToTeam($teamUuid, $applicationUuid)
    {
        $options = [
            'form_params' => [
                'uuid' => $applicationUuid,
            ],
        ];

        return new OperationResponse(
            $this->connector->request('post', "/teams/${teamUuid}/applications", $this->query, $options)
        );
    }

    /**
     * Invites a user to join a team.
     *
     * @param string $teamUuid
     * @param string $email
     * @param array  $roles
     * @return OperationResponse
     */
    public function createTeamInvite($teamUuid, $email, $roles)
    {
        $options = [
            'form_params' => [
                'email' => $email,
                'roles' => $roles
            ],
        ];

        return new OperationResponse(
            $this->connector->request('post', "/teams/${teamUuid}/invites", $options)
        );
    }

    /**
     * Invites a user to become admin of an organization.
     *
     * @param string $organizationUuid
     * @param string $email
     * @return OperationResponse
     */
    public function createOrganizationAdminInvite($organizationUuid, $email)
    {
        $options = [
            'form_params' => [
                'email' => $email,
            ],
        ];

        return new OperationResponse(
            $this->connector->request('post', "/teams/${organizationUuid}/invites", $this->query, $options)
        );
    }

    /**
     * Show all applications associated with a team.
     *
     * @param string $teamUuid
     * @return ApplicationsResponse
     */
    public function teamApplications($teamUuid)
    {
        return new ApplicationsResponse(
            $this->connector->request('get', "/teams/${teamUuid}/applications", $this->query)
        );
    }

    /**
     * Show all members of an organisation.
     *
     * @param string $organizationUuid
     * @return MembersResponse
     */
    public function members($organizationUuid)
    {
        return new MembersResponse(
            $this->connector->request('get', "/organizations/${organizationUuid}/members", $this->query)
        );
    }

    /**
     * Show all members invited to an organisation.
     *
     * @param string $organizationUuid
     * @return InvitationsResponse
     */
    public function invitees($organizationUuid)
    {
        return new InvitationsResponse(
            $this->connector->request('get', "/organizations/${organizationUuid}/team-invites", $this->query)
        );
    }

    /**
     * Delete a member from an organisation.
     *
     * @param string $organizationUuid
     * @param string $memberUuid
     * @return OperationResponse
     */
    public function deleteMember($organizationUuid, $memberUuid)
    {
        return new OperationResponse(
            $this->connector->request(
                'delete',
                "/organizations/${organizationUuid}/members/${memberUuid}",
                $this->query
            )
        );
    }

    /**
     * Show all available permissions.
     *
     * @return PermissionsResponse
     */
    public function permissions()
    {
        return new PermissionsResponse($this->connector->request('get', '/permissions', $this->query));
    }
}
