<?php

namespace AcquiaCloudApi\CloudApi;

use Acquia\Hmac\Guzzle\HmacAuthMiddleware;
use Acquia\Hmac\Key;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\HandlerStack;
use AcquiaCloudApi\Response\CloudApiResponse;

/**
 * Class Client
 * @package AcquiaCloudApi\CloudApi
 */
class Client extends GuzzleClient
{
    /**
     *
     */
    const BASE_URI = 'https://cloud.acquia.com/api';

    /**
     * @param array $config
     * @return static
     */
    public static function factory($config = array())
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
     * @param $verb
     * @param $path
     * @param array $options
     * @return CloudApiResponse
     */
    private function makeRequest($verb, $path, Array $options = array())
    {
        try {
            $response = $this->$verb(self::BASE_URI . $path, $options);
        } catch (ClientException $e) {
            print $e->getMessage();
            $response = $e->getResponse();
        }

        return new CloudApiResponse($response);
    }

    /**
     * @return CloudApiResponse
     */
    public function applications()
    {
        return $this->makeRequest('get', '/applications');
    }

    /**
     * @param string $uuid
     * @return CloudApiResponse
     */
    public function databases($uuid)
    {
        return $this->makeRequest('get', "/applications/${uuid}/databases");
    }

    /**
     * @param string $uuid
     * @param string $source
     * @return CloudApiResponse
     */
    public function copyDatabases($uuid, $source)
    {
        $options = [
            'form_params' => [
                'source' => $source,
            ],
        ];

        return $this->makeRequest('post', "/applications/${uuid}/databases", $options);
    }

    /**
     * @param string $id
     * @param string $dbName
     * @return CloudApiResponse
     */
    public function createDatabaseBackup($id, $dbName)
    {
        return $this->makeRequest('post', "/environments/${id}/databases/${dbName}/backups");
    }

    /**
     * @param string $id
     * @return CloudApiResponse
     */
    public function copyFiles($id)
    {
        return $this->makeRequest('post', "/environments/${id}/files");
    }

    /**
     * @param string $id
     * @param string $branch
     * @return CloudApiResponse
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
     * @return CloudApiResponse
     */
    public function domains($id)
    {
        return $this->makeRequest('get', "/environments/${id}/domains");
    }

    /**
     * @param string $id
     * @param string $hostname
     * @return CloudApiResponse
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
     * @return CloudApiResponse
     */
    public function deleteDomain($id, $domain)
    {
        return $this->makeRequest('delete', "/environments/${id}/domains/${domain}");
    }

    /**
     * @param string $id
     * @param string $domains
     * @return CloudApiResponse
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
     * @return CloudApiResponse
     */
    public function tasks($uuid)
    {
        $response = $this->get(self::BASE_URI . "/applications/${uuid}/tasks");

        return new CloudApiResponse($response);
    }

    /**
     * @param string $uuid
     * @return CloudApiResponse
     */
    public function environments($uuid)
    {
        return $this->makeRequest('get', "/applications/${uuid}/environments");
    }

    /**
     * @param string $id
     * @return CloudApiResponse
     */
    public function environment($id)
    {
        return $this->makeRequest('get', "/environments/${id}");
    }

    /**
     * @param string $id
     * @return CloudApiResponse
     */
    public function servers($id)
    {
        return $this->makeRequest('get', "/environments/${id}/servers");
    }

    /**
     * @param string $id
     * @return CloudApiResponse
     */
    public function enableLiveDev($id)
    {
        return $this->makeRequest('post', "/environments/${id}/livedev/actions/enable");
    }

    /**
     * @param string $id
     * @return CloudApiResponse
     */
    public function disableLiveDev($id)
    {
        return $this->makeRequest('post', "/environments/${id}/livedev/actions/disable");
    }

    /**
     * @param string $id
     * @return CloudApiResponse
     */
    public function enableProductionMode($id)
    {
        return $this->makeRequest('post', "/environments/${id}/production-mode/actions/enable");
    }

    /**
     * @param string $id
     * @return CloudApiResponse
     */
    public function disableProductionMode($id)
    {
        return $this->makeRequest('post', "/environments/${id}/production-mode/actions/disable");
    }

    /**
     * @param string $id
     * @return CloudApiResponse
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
     * @return CloudApiResponse
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
     * @return CloudApiResponse
     */
    public function deleteCron($id, $cronId)
    {
        return $this->makeRequest('delete', "/environments/${id}/crons/${cronId}");
    }

    /**
     * @return CloudApiResponse
     */
    public function drushAliases()
    {
        return $this->makeRequest('get', '/account/drush-aliases/download');
    }

}
