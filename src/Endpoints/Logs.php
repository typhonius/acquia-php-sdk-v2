<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;
use AcquiaCloudApi\Response\EnvironmentResponse;
use AcquiaCloudApi\Response\EnvironmentsResponse;
use AcquiaCloudApi\Response\LogstreamResponse;
use AcquiaCloudApi\Response\LogsResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Logs
 * @package AcquiaCloudApi\CloudApi
 */
class Logs extends CloudApiBase implements CloudApiInterface
{

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
        return $this->client->request('get', "/environments/${environmentUuid}/logs/${logType}");
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
