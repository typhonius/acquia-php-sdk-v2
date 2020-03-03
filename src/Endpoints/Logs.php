<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\EnvironmentResponse;
use AcquiaCloudApi\Response\EnvironmentsResponse;
use AcquiaCloudApi\Response\LogstreamResponse;
use AcquiaCloudApi\Response\LogsResponse;
use AcquiaCloudApi\Response\OperationResponse;
use Psr\Http\Message\StreamInterface;

/**
 * Class Logs
 *
 * @package AcquiaCloudApi\CloudApi
 */
class Logs extends CloudApiBase implements CloudApiInterface
{

    /**
     * Returns a list of log files available for download.
     *
     * @param  string $environmentUuid
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
     * @param  string $environmentUuid
     * @param  string $logType
     * @return StreamInterface
     */
    public function download($environmentUuid, $logType)
    {
        return $this->client->request('get', "/environments/${environmentUuid}/logs/${logType}");
    }

    /**
     * Creates a log file snapshot.
     *
     * @param  string $environmentUuid
     * @param  string $logType
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
     * @param  string $environmentUuid
     * @return LogstreamResponse
     */
    public function stream($environmentUuid)
    {
        return new LogstreamResponse(
            $this->client->request('get', "/environments/${environmentUuid}/logstream")
        );
    }
}
