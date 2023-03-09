<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\OperationResponse;
use AcquiaCloudApi\Response\SshKeyResponse;
use AcquiaCloudApi\Response\SshKeysResponse;

/**
 * Class SshKeys
 *
 * @package AcquiaCloudApi\CloudApi
 */
class SshKeys extends CloudApiBase
{
    /**
     * Returns a list of SSL keys.
     *
     * @return SshKeysResponse<SshKeyResponse>
     */
    public function getAll(): SshKeysResponse
    {
        return new SshKeysResponse(
            $this->client->request(
                'get',
                "/account/ssh-keys"
            )
        );
    }

    /**
     * Returns a specific key by key ID.
     *
     *
     */
    public function get(string $keyId): SshKeyResponse
    {
        return new SshKeyResponse(
            $this->client->request(
                'get',
                "/account/ssh-keys/$keyId"
            )
        );
    }

    /**
     * Create an SSH key.
     *
     *
     */
    public function create(string $label, string $public_key): OperationResponse
    {

        $options = [
            'json' => [
                'label' => $label,
                'public_key' => $public_key,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/account/ssh-keys", $options)
        );
    }

    /**
     * Delete a specific key by ID.
     *
     *
     */
    public function delete(string $keyId): OperationResponse
    {
        return new OperationResponse(
            $this->client->request('delete', "/account/ssh-keys/$keyId")
        );
    }
}
