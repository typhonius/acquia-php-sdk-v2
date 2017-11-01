<?php

namespace AcquiaCloudApi\CloudApi;

use Acquia\Hmac\Guzzle\HmacAuthMiddleware;
use Acquia\Hmac\Key;
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

        // @TODO set query string options here for sort, filter, limit, offset

        $client = new static([
            'handler' => $stack,
        ]);

        return $client;
    }

    /**
     * @param string $verb
     * @param string $path
     * @param array $options
     * @return StreamInterface
     */
    private function makeRequest(String $verb, String $path, Array $options = array())
    {

        // @TODO sort, filter, limit, offset
        // Sortable by: 'name', 'label', 'weight'.
        // Filterable by: 'name', 'label', 'weight'.

        $options['query'] = $this->query;

        try {
            $response = $this->$verb(self::BASE_URI . $path, $options);
        } catch (ClientException $e) {
            print $e->getMessage();
            $response = $e->getResponse();
        }

        $cloudApiResponse = new CloudApiResponse($response);

        return $cloudApiResponse->response;
    }

    public function clearQuery()
    {
        $this->query = [];
    }

    public function addFilter($type, $operation, $value)
    {
        $this->query = array_merge($this->query, ['filter' => $type . $operation . $value]);
    }

    /**
     * @return StreamInterface
     */
    public function applications()
    {
        return $this->makeRequest('get', '/applications');
    }

    /**
     * @param string $uuid
     * @return StreamInterface
     */
    public function application($uuid)
    {
        return $this->makeRequest('get', "/applications/${uuid}");
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
     * @return StreamInterface
     */
    public function databases($uuid)
    {
        return $this->makeRequest('get', "/applications/${uuid}/databases");
    }

    /**
     * @param string $id
     * @return StreamInterface
     */
    public function environmentDatabases($id)
    {
        return $this->makeRequest('get', "/environments/${id}/databases");
    }

    /**
     * @param string $uuid
     * @param string $source
     * @return StreamInterface
     */
    public function databaseCopy($uuid, $source)
    {
        $options = [
            'form_params' => [
                'source' => $source,
            ],
        ];

        return $this->makeRequest('post', "/applications/${uuid}/databases", $options);
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
     * @return StreamInterface
     */
    public function databaseBackup($id, $dbName)
    {
        return $this->makeRequest('post', "/environments/${id}/databases/${dbName}/backups");
    }

    /**
     * @param string $id
     * @return StreamInterface
     */
    public function copyFiles($id)
    {
        return $this->makeRequest('post', "/environments/${id}/files");
    }

    /**
     * @param string $id
     * @param string $branch
     * @return StreamInterface
     */
    public function switchCode($id, $branch)
    {

        $options = [
            'form_params' => [
                'branch' => $branch,
            ],
        ];

        return $this->makeRequest('post', "/environments/${id}/code/actions/switch", $options);
    }

    /**
     * @param string $id
     * @return StreamInterface
     */
    public function domains($id)
    {
        return $this->makeRequest('get', "/environments/${id}/domains");
    }

    /**
     * @param string $id
     * @param string $hostname
     * @return StreamInterface
     */
    public function addDomain($id, $hostname)
    {

        $options = [
            'form_params' => [
                'hostname' => $hostname,
            ],
        ];

        return $this->makeRequest('post', "/environments/${id}/domains", $options);
    }

    /**
     * @param string $id
     * @param string $domain
     * @return StreamInterface
     */
    public function deleteDomain($id, $domain)
    {
        return $this->makeRequest('delete', "/environments/${id}/domains/${domain}");
    }

    /**
     * @param string $id
     * @param string $domains
     * @return StreamInterface
     */
    public function purgeVarnishCache($id, $domains)
    {

        $options = [
            'form_params' => [
                'domains' => $domains,
            ],
        ];

        return $this->makeRequest('post', "/environments/${id}/domains/actions/clear-varnish", $options);
    }

    /**
     *
     */
    public function databaseBackups()
    {

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
     * @return StreamInterface
     */
    public function environments($uuid)
    {
        return $this->makeRequest('get', "/applications/${uuid}/environments");
    }

    /**
     * @param string $id
     * @return StreamInterface
     */
    public function environment($id)
    {
        return $this->makeRequest('get', "/environments/${id}");
    }

    /**
     * @param string $id
     * @param string $label
     * @return StreamInterface
     */
    public function environmentLabel($id, $label)
    {

        $options = [
            'form_params' => [
                'label' => $label,
            ],
        ];

        return $this->makeRequest('post', "/environments/${id}/actions/change-label", $options);
    }

    /**
     * @param string $id
     * @return StreamInterface
     */
    public function servers($id)
    {
        return $this->makeRequest('get', "/environments/${id}/servers");
    }

    /**
     * @param string $id
     * @return StreamInterface
     */
    public function enableLiveDev($id)
    {
        return $this->makeRequest('post', "/environments/${id}/livedev/actions/enable");
    }

    /**
     * @param string $id
     * @return StreamInterface
     */
    public function disableLiveDev($id)
    {

        $options = [
            'form_params' => [
                'discard' => 1,
            ],
        ];

        return $this->makeRequest('post', "/environments/${id}/livedev/actions/disable", $options);
    }

    /**
     * @param string $id
     * @return StreamInterface
     */
    public function enableProductionMode($id)
    {
        return $this->makeRequest('post', "/environments/${id}/production-mode/actions/enable");
    }

    /**
     * @param string $id
     * @return StreamInterface
     */
    public function disableProductionMode($id)
    {
        return $this->makeRequest('post', "/environments/${id}/production-mode/actions/disable");
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
