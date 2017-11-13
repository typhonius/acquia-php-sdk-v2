<?php

namespace AcquiaCloudApi\CloudApi;

use Acquia\Hmac\Guzzle\HmacAuthMiddleware;
use Acquia\Hmac\Key;
use AcquiaCloudApi\Response\ApplicationResponse;
use AcquiaCloudApi\Response\ApplicationsResponse;
use AcquiaCloudApi\Response\BackupResponse;
use AcquiaCloudApi\Response\BackupsResponse;
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
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Class Client
 * @package AcquiaCloudApi\CloudApi
 */
class Client extends GuzzleClient
{
    /**
     * @var string BASE_URI
     */
    const BASE_URI = 'https://cloud.acquia.com/api';

    protected $query = [];

    /**
     * @param array $config
     * @return static
     */
    public static function factory(Array $config = array())
    {

        $key = new Key($config['key'], $config['secret']);
        $middleware = new HmacAuthMiddleware($key);
        $stack = HandlerStack::create();
        $stack->push($middleware);

        $client = new static([
            'handler' => $stack,
        ]);

        return $client;
    }

    /**
     * @param string $verb
     * @param string $path
     * @param array $options
     * @return array|object
     */
    private function makeRequest(String $verb, String $path, Array $options = array())
    {

        // @TODO sort, filter, limit, offset
        // Sortable by: 'name', 'label', 'weight'.
        // Filterable by: 'name', 'label', 'weight'.

        $options['query'] = $this->query;

        if (!empty($options['query']['filter']) && is_array($options['query']['filter'])) {
            // Default to an AND filter.
            $options['query']['filter'] = implode(',', $options['query']['filter']);
        }

        try {
            $response = $this->$verb(self::BASE_URI . $path, $options);
        } catch (ClientException $e) {
            print $e->getMessage();
            $response = $e->getResponse();
        }

        return $this->processResponse($response);
    }

    /**
     * @param ResponseInterface $response
     * @return mixed|StreamInterface
     */
    private function processResponse(ResponseInterface $response)
    {

        // @TODO detect status code here and exit early.
        $body = $response->getBody();

        $object = json_decode($body);
        if (json_last_error() === JSON_ERROR_NONE) {
            // JSON is valid
            if (property_exists($object, '_embedded') && property_exists($object->_embedded, 'items')) {
                $return = $object->_embedded->items;
            } elseif (property_exists($object, 'error')) {
                $this->error = true;
                $return = $object->message;
            } else {
                $return = $object;
            }
        } else {
            $return = $body;
        }

        return $return;
    }

    /**
     *
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
        return new ApplicationsResponse($this->makeRequest('get', '/applications'));
    }

    /**
     * Shows information about an application.
     *
     * @param string $uuid
     * @return ApplicationResponse
     */
    public function application($uuid)
    {
        return new ApplicationResponse($this->makeRequest('get', "/applications/${uuid}"));
    }

    /**
     * Renames an application.
     *
     * @param string $uuid
     * @param string $name
     * @return OperationResponse
     */
    public function applicationRename($uuid, $name)
    {

        $options = [
            'form_params' => [
                'name' => $name,
            ],
        ];

        return new OperationResponse($this->makeRequest('put', "/applications/${uuid}", $options));
    }

    /**
     * Shows all code branches and tags in an application.
     *
     * @param string $uuid
     * @return StreamInterface
     */
    public function code($uuid)
    {
        return $this->makeRequest('get', "/applications/${uuid}/code");
    }

    /**
     * @param string $uuid
     * @return StreamInterface
     */
    public function features($uuid)
    {
        return $this->makeRequest('get', "/applications/${uuid}/features");
    }

    /**
     * Shows all databases in an application.
     *
     * @param string $uuid
     * @return DatabasesResponse
     */
    public function databases($uuid)
    {
        return new DatabasesResponse($this->makeRequest('get', "/applications/${uuid}/databases"));
    }

    /**
     * Shows all databases in an environment.
     *
     * @param string $id
     * @return DatabasesResponse
     */
    public function environmentDatabases($id)
    {
        return new DatabasesResponse($this->makeRequest('get', "/environments/${id}/databases"));
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

        return new OperationResponse($this->makeRequest('post', "/environments/${environmentToUuid}/databases", $options));
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

        return new OperationResponse($this->makeRequest('post', "/applications/${uuid}/databases", $options));
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
        return new OperationResponse($this->makeRequest('post', "/applications/${uuid}/databases/${name}"));
    }

    /**
     * Backup a database.
     *
     * @param string $id
     * @param string $dbName
     * @return OperationResponse
     */
    public function databaseBackup($id, $dbName)
    {
        return new OperationResponse($this->makeRequest('post', "/environments/${id}/databases/${dbName}/backups"));
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
        return new BackupsResponse($this->makeRequest('get', "/environments/${id}/databases/${dbName}/backups"));
    }

    /**
     * Gets information about a database backup.
     *
     * @param string $id
     * @param string $backupId
     * @return BackupResponse
     */
    public function databaseBackupInfo($id, $backupId)
    {
         return new BackupResponse($this->makeRequest('get', "/environments/${id}/database-backups/${backupId}"));
    }

   /**
    * Restores a database backup to a database in an environment.
    *
    * @param string $id
    * @param string $backupId
    * @return OperationResponse
    */
    public function databaseBackupRestore($id, $backupId)
    {
        return new OperationResponse($this->makeRequest('post', "/environments/${id}/database-backups/${backupId}/actions/restore"));
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

        return new OperationResponse($this->makeRequest('post', "/environments/${idTo}/files", $options));
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

        return new OperationResponse($this->makeRequest('post', "/environments/${id}/code/actions/switch", $options));
    }

    /**
     * Shows all domains on an environment.
     *
     * @param string $id
     * @return DomainsResponse
     */
    public function domains($id)
    {
        return new DomainsResponse($this->makeRequest('get', "/environments/${id}/domains"));
    }

    /**
     * Adds a domain to an environment.
     *
     * @param string $id
     * @param string $hostname
     * @return OperationResponse
     */
    public function addDomain($id, $hostname)
    {

        $options = [
            'form_params' => [
                'hostname' => $hostname,
            ],
        ];

        return new OperationResponse($this->makeRequest('post', "/environments/${id}/domains", $options));
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
        return new OperationResponse($this->makeRequest('delete', "/environments/${id}/domains/${domain}"));
    }

    /**
     * Purges varnish for selected domains in an environment.
     *
     * @param string $id
     * @param array  $domains
     * @return OperationResponse
     */
    public function purgeVarnishCache($id, $domains)
    {

        $options = [
            'form_params' => [
                'domains' => $domains,
            ],
        ];

        return new OperationResponse($this->makeRequest('post', "/environments/${id}/domains/actions/clear-varnish", $options));
    }

    /**
     *
     */
    public function moveDomain()
    {

    }

    /**
     * Shows all tasks in an application.
     *
     * @param string $uuid
     * @return TasksResponse
     */
    public function tasks($uuid)
    {
        return new TasksResponse($this->makeRequest('get', "/applications/${uuid}/tasks"));
    }

    /**
     * Shows all environments in an application.
     *
     * @param string $uuid
     * @return EnvironmentsResponse
     */
    public function environments($uuid)
    {
        return new EnvironmentsResponse($this->makeRequest('get', "/applications/${uuid}/environments"));
    }

    /**
     * Gets information about an environment.
     *
     * @param string $id
     * @return EnvironmentResponse
     */
    public function environment($id)
    {
        return new EnvironmentResponse($this->makeRequest('get', "/environments/${id}"));
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

        return new OperationResponse($this->makeRequest('post', "/environments/${id}/actions/change-label", $options));
    }

    /**
     * Show all servers associated with an environment.
     *
     * @param string $id
     * @return ServersResponse
     */
    public function servers($id)
    {
        return new ServersResponse($this->makeRequest('get', "/environments/${id}/servers"));
    }

    /**
     * Enable livedev mode for an environment.
     *
     * @param string $id
     * @return OperationResponse
     */
    public function enableLiveDev($id)
    {
        return new OperationResponse($this->makeRequest('post', "/environments/${id}/livedev/actions/enable"));
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

        return new OperationResponse($this->makeRequest('post', "/environments/${id}/livedev/actions/disable", $options));
    }

    /**
     * Enable production mode for an environment.
     *
     * @param string $id
     * @return OperationResponse
     */
    public function enableProductionMode($id)
    {
        return new OperationResponse($this->makeRequest('post', "/environments/${id}/production-mode/actions/enable"));
    }

    /**
     * Disable production mode for an environment.
     *
     * @param string $id
     * @return OperationResponse
     */
    public function disableProductionMode($id)
    {
        return new OperationResponse($this->makeRequest('post', "/environments/${id}/production-mode/actions/disable"));
    }

    /**
     * Show all cron tasks for an environment.
     *
     * @param string $id The environment ID
     * @return CronsResponse
     */
    public function crons($id)
    {
        return new CronsResponse($this->makeRequest('get', "/environments/${id}/crons"));
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
        return new CronResponse($this->makeRequest('get', "/environments/${id}/crons/${cronId}"));
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
    public function addCron($id, $command, $frequency, $label)
    {

        $options = [
            'form_params' => [
                'command' => $command,
                'frequency' => $frequency,
                'label' => $label,
            ],
        ];

        return new OperationResponse($this->makeRequest('post', "/environments/${id}/crons", $options));
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
        return new OperationResponse($this->makeRequest('delete', "/environments/${id}/crons/${cronId}"));
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
        return new OperationResponse($this->makeRequest('post', "/environments/${id}/crons/${cronId}/actions/disable"));
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
        return new OperationResponse($this->makeRequest('post', "/environments/${id}/crons/${cronId}/actions/enable"));
    }

    /**
     * @return StreamInterface
     */
    public function drushAliases()
    {
        return $this->makeRequest('get', '/account/drush-aliases/download');
    }

    /**
     * Show insights data from an application.
     *
     * @param string $uuid
     * @return InsightsResponse
     */
    public function applicationInsights($uuid)
    {
        return new InsightsResponse($this->makeRequest('get', "/applications/${uuid}/insight"));
    }

    /**
     * Show insights data from a specific environment.
     *
     * @param string $id
     * @return InsightsResponse
     */
    public function environmentInsights($id)
    {
        return new InsightsResponse($this->makeRequest('get', "/environments/${id}/insight"));
    }

    /**
     * Show all organizations.
     *
     * @return OrganizationsResponse
     */
    public function organizations()
    {
        return new OrganizationsResponse($this->makeRequest('get', '/organizations'));
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
        return new ApplicationsResponse($this->makeRequest('get', "/organizations/${uuid}/applications"));
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
//        return new OperationResponse($this->makeRequest('post', '/organizations', $options));
//    }

    /**
     * Show all roles in an organization.
     *
     * @param string $uuid
     * @return RolesResponse
     */
    public function organizationRoles($uuid)
    {
        return new RolesResponse($this->makeRequest('get', "/organizations/${uuid}/roles"));
    }

    /**
     * @param string $roleUuid
     * @param array  $permissions
     * @return OperationResponse
     */
    public function roleUpdatePermissions($roleUuid, Array $permissions)
    {
        $options = [
            'form_params' => [
                'permissions' => $permissions,
            ],
        ];

        return new OperationResponse($this->makeRequest('put', "/roles/${roleUuid}", $options));
    }

    /**
     * @param string      $uuid
     * @param string      $name
     * @param array       $permissions
     * @param null|string $description
     * @return OperationResponse
     */
    public function organizationRoleCreate($uuid, $name, Array $permissions, $description = null)
    {
        $options = [
            'form_params' => [
                'name' => $name,
                'permissions' => $permissions,
                'description' => $description,
            ],
        ];

        return new OperationResponse($this->makeRequest('post', "/organizations/${uuid}/roles", $options));
    }

    /**
     * @param string $roleUuid
     * @return OperationResponse
     */
    public function roleRemove($roleUuid)
    {
        return new OperationResponse($this->makeRequest('delete', "/roles/${roleUuid}"));
    }

    /**
     * Show all teams in an organization.
     *
     * @param string $organizationUuid
     * @return TeamsResponse
     */
    public function organizationTeams($organizationUuid)
    {
        return new TeamsResponse($this->makeRequest('get', "/organizations/${organizationUuid}/teams"));
    }

    /**
     * Show all teams.
     *
     * @return TeamsResponse
     */
    public function teams()
    {
        return new TeamsResponse($this->makeRequest('get', '/teams'));
    }

    /**
     * Create a new team.
     *
     * @param string $uuid
     * @param string $name
     * @return OperationResponse
     */
    public function teamCreate($uuid, $name)
    {
        $options = [
            'form_params' => [
                'name' => $name,
            ],
        ];

        return new OperationResponse($this->makeRequest('post', "/organizations/${uuid}/teams", $options));
    }

    /**
     * @param string $teamUuid
     * @return OperationResponse
     */
    public function teamRemove($teamUuid)
    {
        return new OperationResponse($this->makeRequest('delete', "/teams/${teamUuid}"));
    }

    /**
     * @param string $teamUuid
     * @param string $applicationUuid
     * @return OperationResponse
     */
    public function teamAddApplication($teamUuid, $applicationUuid)
    {
        $options = [
            'form_params' => [
                'uuid' => $applicationUuid,
            ],
        ];

        return new OperationResponse($this->makeRequest('post', "/teams/${teamUuid}/applications", $options));
    }

    /**
     * Invites a user to join a team.
     *
     * @param string $uuid
     * @param string $email
     * @param array  $roles
     * @return OperationResponse
     */
    public function teamInvite($uuid, $email, $roles)
    {
        $options = [
            'form_params' => [
                'email' => $email,
                'roles' => $roles
            ],
        ];

        return new OperationResponse($this->makeRequest('post', "/teams/${uuid}/invites", $options));
    }

    /**
     * Show all applications associated with a team.
     *
     * @param string $uuid
     * @return ApplicationResponse
     */
    public function teamApplications($uuid)
    {
        return new ApplicationResponse($this->makeRequest('get', "/teams/${uuid}/applications"));
    }

    /**
     * Show all members of an organisation.
     *
     * @param string $uuid
     * @return MembersResponse
     */
    public function members($uuid)
    {
        return new MembersResponse($this->makeRequest('get', "/organizations/${uuid}/members"));
    }

    /**
     * Show all members invited to an organisation.
     *
     * @param string $uuid
     * @return StreamInterface
     */
    public function invitees($uuid)
    {
        return new InvitationsResponse($this->makeRequest('get', "/organizations/${uuid}/team-invites"));
    }

    /**
     * Delete a member from an organisation.
     *
     * @param string $uuidSite
     * @param string $uuidMember
     * @return OperationResponse
     */
    public function deleteMember($uuidSite, $uuidMember)
    {
        return new OperationResponse($this->makeRequest('delete', "/organizations/${uuidSite}/members/${uuidMember}"));
    }

    /**
     * Show all available permissions.
     *
     * @return PermissionsResponse
     */
    public function permissions()
    {
        return new PermissionsResponse($this->makeRequest('get', '/permissions'));
    }
}
