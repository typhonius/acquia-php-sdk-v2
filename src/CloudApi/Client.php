<?php

namespace AcquiaCloudApi\CloudApi;

use Acquia\Hmac\Guzzle\HmacAuthMiddleware;
use Acquia\Hmac\Key;
use AcquiaCloudApi\Response\ApplicationResponse;
use AcquiaCloudApi\Response\ApplicationsResponse;
use AcquiaCloudApi\Response\BackupResponse;
use AcquiaCloudApi\Response\BackupsResponse;
use AcquiaCloudApi\Response\DatabasesResponse;
use AcquiaCloudApi\Response\DomainsResponse;
use AcquiaCloudApi\Response\EnvironmentResponse;
use AcquiaCloudApi\Response\EnvironmentsResponse;
use AcquiaCloudApi\Response\OperationResponse;
use AcquiaCloudApi\Response\ServersResponse;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\HandlerStack;
use AcquiaCloudApi\Response\CloudApiResponse;
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

        $cloudApiResponse = new CloudApiResponse($response);

        return $cloudApiResponse->response;
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
     * @return ApplicationsResponse
     */
    public function applications()
    {
        return new ApplicationsResponse($this->makeRequest('get', '/applications'));
    }

    /**
     * @param string $uuid
     * @return ApplicationResponse
     */
    public function application($uuid)
    {
        return new ApplicationResponse($this->makeRequest('get', "/applications/${uuid}"));
    }

    /**
     * @param string $uuid
     * @param string $name
     * @return StreamInterface
     */
    public function applicationRename($uuid, $name)
    {

        $options = [
            'form_params' => [
                'name' => $name,
            ],
        ];

        return $this->makeRequest('put', "/applications/${uuid}", $options);
    }

    /**
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
     * @param string $uuid
     * @return DatabasesResponse
     */
    public function databases($uuid)
    {
        return new DatabasesResponse($this->makeRequest('get', "/applications/${uuid}/databases"));
    }

    /**
     * @param string $id
     * @return DatabasesResponse
     */
    public function environmentDatabases($id)
    {
      return new DatabasesResponse($this->makeRequest('get', "/environments/${id}/databases"));
    }

    /**
     * @param string $environmentFromId
     * @param string $dbName
     * @param string $environmentToId
     * @return StreamInterface
     */
    public function databaseCopy($environmentFromId, $dbName, $environmentToId)
    {
        $options = [
            'form_params' => [
                'name' => $dbName,
                'source' => $environmentFromId,
            ],
        ];

        return $this->makeRequest('post', "/applications/${environmentToId}/databases", $options);
    }

    /**
     * @param string $uuid
     * @param string $name
     * @return StreamInterface
     */
    public function databaseCreate($uuid, $name)
    {
        $options = [
            'form_params' => [
                'name' => $name,
            ],
        ];

        return $this->makeRequest('post', "/applications/${uuid}/databases", $options);
    }

    /**
     * @param string $uuid
     * @param string $name
     * @return StreamInterface
     */
    public function databaseDelete($uuid, $name)
    {
        return $this->makeRequest('post', "/applications/${uuid}/databases/${name}");
    }

    /**
     * @param string $uuid
     * @return StreamInterface
     */
    public function insight($uuid)
    {
        return $this->makeRequest('get', "/applications/${uuid}/insight");
    }

    /**
     * @param string $id
     * @param string $dbName
     * @return OperationResponse
     */
    public function databaseBackup($id, $dbName)
    {
        return new OperationResponse($this->makeRequest('post', "/environments/${id}/databases/${dbName}/backups"));
    }

     /**
      * @param $id
      * @param $dbName
      * @return BackupsResponse
      */
     public function databaseBackups($id, $dbName)
     {
         return new BackupsResponse($this->makeRequest('get', "/environments/${id}/databases/${dbName}/backups"));
     }

    /**
     * @param $id
     * @param $backupId
     * @return BackupResponse
     */
    public function databaseBackupInfo($id, $backupId)
    {
         return new BackupResponse($this->makeRequest('get', "/environments/${id}/database-backups/${backupId}"));
    }

    /**
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
     * @param string $id
     * @return DomainsResponse
     */
    public function domains($id)
    {
        return new DomainsResponse($this->makeRequest('get', "/environments/${id}/domains"));
    }

    /**
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
     * @param string $id
     * @param string $domain
     * @return OperationResponse
     */
    public function deleteDomain($id, $domain)
    {
        return new OperationResponse($this->makeRequest('delete', "/environments/${id}/domains/${domain}"));
    }

    /**
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
     * @param string $uuid
     * @return StreamInterface
     */
    public function tasks($uuid)
    {
        return $this->makeRequest('get', "/applications/${uuid}/tasks");
    }

    /**
     * @param string $uuid
     * @return EnvironmentsResponse
     */
    public function environments($uuid)
    {
        return new EnvironmentsResponse($this->makeRequest('get', "/applications/${uuid}/environments"));
    }

    /**
     * @param string $id
     * @return EnvironmentResponse
     */
    public function environment($id)
    {
        return new EnvironmentResponse($this->makeRequest('get', "/environments/${id}"));
    }

    /**
     * @param string $id
     * @param string $label
     * @return OperationResponse
     */
    public function environmentLabel($id, $label)
    {

        $options = [
            'form_params' => [
                'label' => $label,
            ],
        ];

        return new OperationResponse($this->makeRequest('post', "/environments/${id}/actions/change-label", $options));
    }

    /**
     * @param string $id
     * @return ServersResponse
     */
    public function servers($id)
    {
        return new ServersResponse($this->makeRequest('get', "/environments/${id}/servers"));
    }

    /**
     * @param string $id
     * @return OperationResponse
     */
    public function enableLiveDev($id)
    {
        return new OperationResponse($this->makeRequest('post', "/environments/${id}/livedev/actions/enable"));
    }

    /**
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
     * @param string $id
     * @return OperationResponse
     */
    public function enableProductionMode($id)
    {
        return new OperationResponse($this->makeRequest('post', "/environments/${id}/production-mode/actions/enable"));
    }

    /**
     * @param string $id
     * @return OperationResponse
     */
    public function disableProductionMode($id)
    {
        return new OperationResponse($this->makeRequest('post', "/environments/${id}/production-mode/actions/disable"));
    }

    /**
     * @param string $id
     * @return StreamInterface
     */
    public function crons($id)
    {
        return $this->makeRequest('get', "/environments/${id}/crons");
    }

    /**
     * @param string $id
     * @param string $command
     * @param string $frequency
     * @param string $label
     * @return StreamInterface
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

        return $this->makeRequest('post', "/environments/${id}/crons", $options);
    }

    /**
     * @param string $id
     * @param string $cronId
     * @return StreamInterface
     */
    public function deleteCron($id, $cronId)
    {
        return $this->makeRequest('delete', "/environments/${id}/crons/${cronId}");
    }

    /**
     * @return StreamInterface
     */
    public function drushAliases()
    {
        return $this->makeRequest('get', '/account/drush-aliases/download');
    }

}
