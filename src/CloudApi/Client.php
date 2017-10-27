<?php

namespace AcquiaCloudApi\CloudApi;

use Acquia\Hmac\Guzzle\HmacAuthMiddleware;
use Acquia\Hmac\Key;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\HandlerStack;
use AcquiaCloudApi\Response\CloudApiResponse;

class Client extends GuzzleClient
{
    const BASE_URI = 'https://cloud.acquia.com/api';
    const LIVEDEV_ENABLE = 'enable';
    const LIVEDEV_DISABLE = 'disable';

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

    public function applications()
    {
        return $this->makeRequest('get', '/applications');
    }

    public function databases($uuid)
    {
        return $this->makeRequest('get', "/applications/${uuid}/databases");
    }

    public function copyDatabases($uuid, $source)
    {
        $options = [
        'form_params' => array(
        'source' => $source,
        )
        ];

        return $this->makeRequest('post', "/applications/${uuid}/databases", $options);

    }

    public function createDatabaseBackup($id, $db_name)
    {
        return $this->makeRequest('post', "/environments/${id}/databases/${db_name}/backups");
    }

    public function copyFiles($id)
    {
        return $this->makeRequest('post', "/environments/${id}/files");
    }

    public function switchCode($id, $branch)
    {

        $options = [
        'form_params' => array(
        'branch' => $branch,
        )
        ];

        return $this->makeRequest('post', "/environments/${id}/code/actions/switch", $options);

    }

    public function domains($id)
    {
        return $this->makeRequest('get', "/environments/${id}/domains");
    }

    public function addDomain($id, $hostname)
    {

        $options = [
            'form_params' => [
                'hostname' => $hostname,
            ],
        ];

        return $this->makeRequest('post', "/environments/${id}/domains", $options);

    }

    public function deleteDomain($id, $domain)
    {
        return $this->makeRequest('delete', "/environments/${id}/domains/${domain}");
    }

    public function purgeVarnishCache($id, $domains)
    {

        $options = [
            'form_params' => [
                'domains' => $domains,
            ],
        ];

        return $this->makeRequest('post', "/environments/${id}/domains/actions/clear-varnish", $options);

    }

    public function databaseBackups()
    {

    }



    public function moveDomain()
    {

    }

    public function tasks($uuid)
    {
        $response = $this->get(self::BASE_URI . "/applications/${uuid}/tasks");
        return new CloudApiResponse($response);
    }

    public function environments($uuid)
    {

        return $this->makeRequest('get', "/applications/${uuid}/environments");

    }

    public function environment($id)
    {

        return $this->makeRequest('get', "/environments/${id}");

    }

    public function servers($id)
    {

        return $this->makeRequest('get', "/environments/${id}/servers");

    }

    public function enableLiveDev($id)
    {

        return $this->makeRequest('post', "/environments/${id}/livedev/actions/enable");

    }

    public function disableLiveDev($id)
    {
        return $this->makeRequest('post', "/environments/${id}/livedev/actions/disable");
    }

    public function enableProductionMode($id)
    {

        return $this->makeRequest('post', "/environments/${id}/production-mode/actions/enable");

    }

    public function disableProductionMode($id)
    {

        return $this->makeRequest('post', "/environments/${id}/production-mode/actions/disable");

    }

    public function crons($id)
    {
        return $this->makeRequest('get', "/environments/{$id}/crons");
    }

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

    public function deleteCron($id, $cron_id)
    {
        return $this->makeRequest('delete', "/environments/${id}/crons/${cron_id}");
    }

    public function drushAliases()
    {
        return $this->makeRequest('get', '/account/drush-aliases/download');
    }

}
