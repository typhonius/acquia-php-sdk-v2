<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\OperationResponse;
use AcquiaCloudApi\Response\LogForwardingDestinationsResponse;
use AcquiaCloudApi\Response\LogForwardingDestinationResponse;

/**
 * Class LogForwardingDestinations
 *
 * @package AcquiaCloudApi\CloudApi
 */
class LogForwardingDestinations extends CloudApiBase implements CloudApiInterface
{

    /**
     * Returns a list of log forwarding destinations.
     *
     * @param  string $environmentUuid The environment ID
     * @return LogForwardingDestinationsResponse
     */
    public function getAll($environmentUuid)
    {
        return new LogForwardingDestinationsResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/log-forwarding-destinations"
            )
        );
    }

    /**
     * Returns a specific log forwarding destination.
     *
     * @param  string $environmentUuid The environment ID
     * @param  int    $destinationId
     * @return LogForwardingDestinationResponse
     */
    public function get($environmentUuid, $destinationId)
    {
        return new LogForwardingDestinationResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/log-forwarding-destinations/${destinationId}"
            )
        );
    }

    /**
     * Creates a log forwarding destination.
     *
     * @param  string $environmentUuid
     * @param  string $label
     * @param  array  $sources
     * @param  string $consumer
     * @param  array  $credentials
     * @param  string $address
     * @return OperationResponse
     */
    public function create($environmentUuid, $label, $sources, $consumer, $credentials, $address)
    {

        $options = [
            'json' => [
                'label' => $label,
                'sources' => $sources,
                'consumer' => $consumer,
                'credentials' => $credentials,
                'address' => $address
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/environments/${environmentUuid}/log-forwarding-destinations", $options)
        );
    }

    /**
     * Delete a specific log forwarding destination.
     *
     * @param  string $environmentUuid
     * @param  int    $destId
     * @return OperationResponse
     */
    public function delete($environmentUuid, $destId)
    {
        return new OperationResponse(
            $this->client->request('delete', "/environments/${environmentUuid}/log-forwarding-destinations/${destId}")
        );
    }

    /**
     * Disables a log forwarding destination.
     *
     * @param  string $environmentUuid
     * @param  int    $destId
     * @return OperationResponse
     */
    public function disable($environmentUuid, $destId)
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentUuid}/log-forwarding-destinations/${destId}/actions/disable"
            )
        );
    }

    /**
     * Enables a log forwarding destination.
     *
     * @param  string $environmentUuid
     * @param  int    $destId
     * @return OperationResponse
     */
    public function enable($environmentUuid, $destId)
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentUuid}/log-forwarding-destinations/${destId}/actions/enable"
            )
        );
    }

    /**
     * Updates a log forwarding destination.
     *
     * @param  string $environmentUuid
     * @param  int    $destId
     * @param  string $label
     * @param  array  $sources
     * @param  string $consumer
     * @param  array  $creds
     * @param  string $address
     * @return OperationResponse
     */
    public function update($environmentUuid, $destId, $label, $sources, $consumer, $creds, $address)
    {

        $options = [
            'json' => [
                'label' => $label,
                'sources' => $sources,
                'consumer' => $consumer,
                'credentials' => $creds,
                'address' => $address
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'put',
                "/environments/${environmentUuid}/log-forwarding-destinations/${destId}",
                $options
            )
        );
    }
}
