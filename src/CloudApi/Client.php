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
    protected $connector;

    protected $query = [];

  /**
   * Client constructor.
   * @param ConnectorInterface $connector
   */
    public function __construct(ConnectorInterface $connector)
    {
        $this->connector = $connector;
    }

  /**
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
     * @param string $uuid
     * @return ApplicationResponse
     */
    public function application($uuid)
    {
        return new ApplicationResponse($this->connector->request('get', "/applications/${uuid}", $this->query));
    }

    /**
     * Renames an application.
     *
     * @param string $uuid
     * @param string $name
     * @return OperationResponse
     */
    public function renameApplication($uuid, $name)
    {

        $options = [
            'form_params' => [
                'name' => $name,
            ],
        ];

        return new OperationResponse($this->connector->request('put', "/applications/${uuid}", $options, $this->query));
    }

    /**
     * Shows all code branches and tags in an application.
     *
     * @param string $uuid
     * @return BranchesResponse
     */
    public function code($uuid)
    {
        return new BranchesResponse($this->connector->request('get', "/applications/${uuid}/code", $this->query));
    }

    /**
     * Shows all databases in an application.
     *
     * @param string $uuid
     * @return DatabasesResponse
     */
    public function databases($uuid)
    {
        return new DatabasesResponse($this->connector->request('get', "/applications/${uuid}/databases", $this->query));
    }

    /**
     * Shows all databases in an environment.
     *
     * @param string $id
     * @return DatabasesResponse
     */
    public function environmentDatabases($id)
    {
        return new DatabasesResponse($this->connector->request('get', "/environments/${id}/databases", $this->query));
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
     * @param string $uuid
     * @param string $name
     * @return OperationResponse
     */
    public function databaseCreate($uuid, $name)
    {
        $options = [
            'form_params' => [
                'name' => $name,
            ],
        ];

        return new OperationResponse(
            $this->connector->request('post', "/applications/${uuid}/databases", $this->query, $options)
        );
    }

    /**
     * Delete a database.
     *
     * @param string $uuid
     * @param string $name
     * @return OperationResponse
     */
    public function databaseDelete($uuid, $name)
    {
        return new OperationResponse(
            $this->connector->request('post', "/applications/${uuid}/databases/${name}", $this->query)
        );
    }

    /**
     * Backup a database.
     *
     * @param string $id
     * @param string $dbName
     * @return OperationResponse
     */
    public function createDatabaseBackup($id, $dbName)
    {
        return new OperationResponse(
            $this->connector->request('post', "/environments/${id}/databases/${dbName}/backups", $this->query)
        );
    }

    /**
     * Shows all database backups in an environment.
     *
     * @param string $id
     * @param string $dbName
     * @return BackupsResponse
     */
    public function databaseBackups($id, $dbName)
    {
        return new BackupsResponse(
            $this->connector->request('get', "/environments/${id}/databases/${dbName}/backups", $this->query)
        );
    }

    /**
     * Gets information about a database backup.
     *
     * @param string $id
     * @param string $backupId
     * @return BackupResponse
     */
    public function databaseBackup($id, $backupId)
    {
         return new BackupResponse(
             $this->connector->request('get', "/environments/${id}/database-backups/${backupId}", $this->query)
         );
    }

   /**
    * Restores a database backup to a database in an environment.
    *
    * @param string $id
    * @param string $backupId
    * @return OperationResponse
    */
    public function restoreDatabaseBackup($id, $backupId)
    {
        return new OperationResponse(
            $this->connector->request(
                'post',
                "/environments/${id}/database-backups/${backupId}/actions/restore",
                $this->query
            )
        );
    }

    /**
     * Copies files from an environment to another environment.
     *
     * @param string $idFrom
     * @param string $idTo
     * @return OperationResponse
     */
    public function copyFiles($idFrom, $idTo)
    {
        $options = [
           'form_params' => [
               'source' => $idFrom,
           ],
        ];

        return new OperationResponse(
            $this->connector->request('post', "/environments/${idTo}/files", $this->query, $options)
        );
    }

    /**
     * Deploys a code branch/tag to an environment.
     *
     * @param string $id
     * @param string $branch
     * @return OperationResponse
     */
    public function switchCode($id, $branch)
    {

        $options = [
            'form_params' => [
                'branch' => $branch,
            ],
        ];

        return new OperationResponse(
            $this->connector->request('post', "/environments/${id}/code/actions/switch", $this->query, $options)
        );
    }

    /**
     * Shows all domains on an environment.
     *
     * @param string $id
     * @return DomainsResponse
     */
    public function domains($id)
    {
        return new DomainsResponse($this->connector->request('get', "/environments/${id}/domains", $this->query));
    }

    /**
     * Adds a domain to an environment.
     *
     * @param string $id
     * @param string $hostname
     * @return OperationResponse
     */
    public function createDomain($id, $hostname)
    {

        $options = [
            'form_params' => [
                'hostname' => $hostname,
            ],
        ];

        return new OperationResponse(
            $this->connector->request('post', "/environments/${id}/domains", $this->query, $options)
        );
    }

    /**
     * Deletes a domain from an environment.
     *
     * @param string $id
     * @param string $domain
     * @return OperationResponse
     */
    public function deleteDomain($id, $domain)
    {
        return new OperationResponse(
            $this->connector->request('delete', "/environments/${id}/domains/${domain}", $this->query)
        );
    }

    /**
     * Purges varnish for selected domains in an environment.
     *
     * @param string $id
     * @param array  $domains
     * @return OperationResponse
     */
    public function purgeVarnishCache($id, array $domains)
    {

        $options = [
            'form_params' => [
                'domains' => $domains,
            ],
        ];

        return new OperationResponse(
            $this->connector->request(
                'post',
                "/environments/${id}/domains/actions/clear-varnish",
                $this->query,
                $this->query,
                $options
            )
        );
    }

    /**
     * Shows all tasks in an application.
     *
     * @param string $uuid
     * @return TasksResponse
     */
    public function tasks($uuid)
    {
        return new TasksResponse($this->connector->request('get', "/applications/${uuid}/tasks", $this->query));
    }

    /**
     * Shows all environments in an application.
     *
     * @param string $uuid
     * @return EnvironmentsResponse
     */
    public function environments($uuid)
    {
        return new EnvironmentsResponse(
            $this->connector->request('get', "/applications/${uuid}/environments", $this->query)
        );
    }

    /**
     * Gets information about an environment.
     *
     * @param string $id
     * @return EnvironmentResponse
     */
    public function environment($id)
    {
        return new EnvironmentResponse($this->connector->request('get', "/environments/${id}", $this->query));
    }

    /**
     * Renames an environment.
     *
     * @param string $id
     * @param string $label
     * @return OperationResponse
     */
    public function renameEnvironment($id, $label)
    {

        $options = [
            'form_params' => [
                'label' => $label,
            ],
        ];

        return new OperationResponse(
            $this->connector->request('post', "/environments/${id}/actions/change-label", $this->query, $options)
        );
    }

    /**
     * Show all servers associated with an environment.
     *
     * @param string $id
     * @return ServersResponse
     */
    public function servers($id)
    {
        return new ServersResponse($this->connector->request('get', "/environments/${id}/servers", $this->query));
    }

    /**
     * Enable livedev mode for an environment.
     *
     * @param string $id
     * @return OperationResponse
     */
    public function enableLiveDev($id)
    {
        return new OperationResponse(
            $this->connector->request('post', "/environments/${id}/livedev/actions/enable", $this->query)
        );
    }

    /**
     * Disable livedev mode for an environment.
     *
     * @param string $id
     * @return OperationResponse
     */
    public function disableLiveDev($id)
    {

        $options = [
            'form_params' => [
                'discard' => 1,
            ],
        ];

        return new OperationResponse(
            $this->connector->request('post', "/environments/${id}/livedev/actions/disable", $this->query, $options)
        );
    }

    /**
     * Enable production mode for an environment.
     *
     * @param string $id
     * @return OperationResponse
     */
    public function enableProductionMode($id)
    {
        return new OperationResponse(
            $this->connector->request('post', "/environments/${id}/production-mode/actions/enable", $this->query)
        );
    }

    /**
     * Disable production mode for an environment.
     *
     * @param string $id
     * @return OperationResponse
     */
    public function disableProductionMode($id)
    {
        return new OperationResponse(
            $this->connector->request('post', "/environments/${id}/production-mode/actions/disable", $this->query)
        );
    }

    /**
     * Show all cron tasks for an environment.
     *
     * @param string $id The environment ID
     * @return CronsResponse
     */
    public function crons($id)
    {
        return new CronsResponse($this->connector->request('get', "/environments/${id}/crons", $this->query));
    }

    /**
     * Get information about a cron task.
     *
     * @param string $id     The environment ID
     * @param int    $cronId
     * @return CronResponse
     */
    public function cron($id, $cronId)
    {
        return new CronResponse($this->connector->request('get', "/environments/${id}/crons/${cronId}", $this->query));
    }

    /**
     * Add a cron task.
     *
     * @param string $id
     * @param string $command
     * @param string $frequency
     * @param string $label
     * @return OperationResponse
     */
    public function createCron($id, $command, $frequency, $label)
    {

        $options = [
            'form_params' => [
                'command' => $command,
                'frequency' => $frequency,
                'label' => $label,
            ],
        ];

        return new OperationResponse(
            $this->connector->request('post', "/environments/${id}/crons", $this->query, $options)
        );
    }

    /**
     * Delete a cron task.
     *
     * @param string $id
     * @param int    $cronId
     * @return OperationResponse
     */
    public function deleteCron($id, $cronId)
    {
        return new OperationResponse(
            $this->connector->request('delete', "/environments/${id}/crons/${cronId}", $this->query)
        );
    }

    /**
     * Disable a cron task.
     *
     * @param string $id
     * @param int    $cronId
     * @return OperationResponse
     */
    public function disableCron($id, $cronId)
    {
        return new OperationResponse(
            $this->connector->request('post', "/environments/${id}/crons/${cronId}/actions/disable", $this->query)
        );
    }

    /**
     * Enable a cron task.
     *
     * @param string $id
     * @param int    $cronId
     * @return OperationResponse
     */
    public function enableCron($id, $cronId)
    {
        return new OperationResponse(
            $this->connector->request('post', "/environments/${id}/crons/${cronId}/actions/enable", $this->query)
        );
    }

    /**
     * @return StreamInterface
     */
    public function drushAliases()
    {
        return $this->connector->request('get', '/account/drush-aliases/download', $this->query);
    }

    /**
     * Show insights data from an application.
     *
     * @param string $uuid
     * @return InsightsResponse
     */
    public function applicationInsights($uuid)
    {
        return new InsightsResponse($this->connector->request('get', "/applications/${uuid}/insight", $this->query));
    }

    /**
     * Show insights data from a specific environment.
     *
     * @param string $id
     * @return InsightsResponse
     */
    public function environmentInsights($id)
    {
        return new InsightsResponse($this->connector->request('get', "/environments/${id}/insight", $this->query));
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
     * @param string $uuid
     *
     * @return ApplicationsResponse
     */
    public function organizationApplications($uuid)
    {
        return new ApplicationsResponse(
            $this->connector->request('get', "/organizations/${uuid}/applications", $this->query)
        );
    }

    /**
     * @param $name
     * @return OperationResponse
     */
//    public function organizationCreate($name)
//    {
//        $options = [
//            'form_params' => [
//                'name' => $name,
//            ],
//        ];
//
//        return new OperationResponse($this->request('post', '/organizations', $options));
//    }

    /**
     * Show all roles in an organization.
     *
     * @param string $uuid
     * @return RolesResponse
     */
    public function organizationRoles($uuid)
    {
        return new RolesResponse($this->connector->request('get', "/organizations/${uuid}/roles", $this->query));
    }

    /**
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
     * @param string      $uuid
     * @param string      $name
     * @param array       $permissions
     * @param null|string $description
     * @return OperationResponse
     */
    public function createRole($uuid, $name, array $permissions, $description = null)
    {
        $options = [
            'form_params' => [
                'name' => $name,
                'permissions' => $permissions,
                'description' => $description,
            ],
        ];

        return new OperationResponse(
            $this->connector->request('post', "/organizations/${uuid}/roles", $this->query, $options)
        );
    }

    /**
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
     * @param string $uuid
     * @param string $name
     * @return OperationResponse
     */
    public function createTeam($uuid, $name)
    {
        $options = [
            'form_params' => [
                'name' => $name,
            ],
        ];

        return new OperationResponse(
            $this->connector->request('post', "/organizations/${uuid}/teams", $this->query, $options)
        );
    }

    /**
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
     * @return ApplicationResponse
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
