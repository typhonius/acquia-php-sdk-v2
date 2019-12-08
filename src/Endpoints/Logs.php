<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;
use AcquiaCloudApi\Response\EnvironmentResponse;
use AcquiaCloudApi\Response\EnvironmentsResponse;
use AcquiaCloudApi\Response\LogstreamResponse;
use AcquiaCloudApi\Response\LogsResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Client
 * @package AcquiaCloudApi\CloudApi
 */
class Logs implements CloudApi
{

    /** @var ClientInterface The API client. */
    protected $client;

    /**
     * Client constructor.
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Returns a list of log files available for download.
     *
     * @return LogsResponse
     */
    public function getAll($environmentUuid)
    {
        return new LogsResponse(
            $this->client->request('get', "/environments/${environmentUuid}/logs")
        );
    }

    /**
     * Downloads a log file.
     *
     * @return object
     */
    public function download($environmentUuid, $logType)
    {
        return new LogsResponse(
            $this->client->request('get', "/environments/${environmentUuid}/logs/${logType}")
        );
    }

    /**
     * Creates a log file snapshot.
     *
     * @return OperationResponse
     */
    public function snapshot($environmentUuid, $logType)
    {
        return new OperationResponse(
            $this->client->request('post', "/environments/${environmentUuid}/logs/${logType}")
        );
    }

    /**
     * Returns logstream WSS stream information.
     *
     * @return LogstreamResponse
     */
    public function stream($environmentUuid)
    {
        return new LogstreamResponse(
            $this->client->request('get', "/environments/${environmentUuid}/logstream")
        );
    }
}
