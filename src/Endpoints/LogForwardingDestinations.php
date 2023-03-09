<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\LogForwardingDestinationResponse;
use AcquiaCloudApi\Response\LogForwardingDestinationsResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class LogForwardingDestinations
 *
 * @package AcquiaCloudApi\CloudApi
 */
class LogForwardingDestinations extends CloudApiBase
{
    /**
     * Returns a list of log forwarding destinations.
     *
     * @param string $environmentUuid The environment ID
     * @return LogForwardingDestinationsResponse<LogForwardingDestinationResponse>
     */
    public function getAll(string $environmentUuid): LogForwardingDestinationsResponse
    {
        return new LogForwardingDestinationsResponse(
            $this->client->request(
                'get',
                "/environments/$environmentUuid/log-forwarding-destinations"
            )
        );
    }

    /**
     * Returns a specific log forwarding destination.
     *
     * @param string $environmentUuid The environment ID
     */
    public function get(string $environmentUuid, int $destinationId): LogForwardingDestinationResponse
    {
        return new LogForwardingDestinationResponse(
            $this->client->request(
                'get',
                "/environments/$environmentUuid/log-forwarding-destinations/$destinationId"
            )
        );
    }

    /**
     * Creates a log forwarding destination.
     *
     * @param mixed[] $sources
     * @param mixed[] $credentials
     */
    public function create(
        string $environmentUuid,
        string $label,
        array $sources,
        string $consumer,
        array $credentials,
        string $address
    ): OperationResponse {

        $options = [
            'json' => [
                'label' => $label,
                'sources' => $sources,
                'consumer' => $consumer,
                'credentials' => $credentials,
                'address' => $address,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/environments/$environmentUuid/log-forwarding-destinations", $options)
        );
    }

    /**
     * Delete a specific log forwarding destination.
     */
    public function delete(string $environmentUuid, int $destId): OperationResponse
    {
        return new OperationResponse(
            $this->client->request('delete', "/environments/$environmentUuid/log-forwarding-destinations/$destId")
        );
    }

    /**
     * Disables a log forwarding destination.
     */
    public function disable(string $environmentUuid, int $destId): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/$environmentUuid/log-forwarding-destinations/$destId/actions/disable"
            )
        );
    }

    /**
     * Enables a log forwarding destination.
     */
    public function enable(string $environmentUuid, int $destId): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/$environmentUuid/log-forwarding-destinations/$destId/actions/enable"
            )
        );
    }

    /**
     * Updates a log forwarding destination.
     *
     * @param mixed[] $sources
     * @param mixed[] $creds
     */
    public function update(
        string $environmentUuid,
        int $destId,
        string $label,
        array $sources,
        string $consumer,
        array $creds,
        string $address
    ): OperationResponse {
        $options = [
            'json' => [
                'label' => $label,
                'sources' => $sources,
                'consumer' => $consumer,
                'credentials' => $creds,
                'address' => $address,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'put',
                "/environments/$environmentUuid/log-forwarding-destinations/$destId",
                $options
            )
        );
    }
}
