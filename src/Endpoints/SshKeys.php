<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\SshKeysResponse;
use AcquiaCloudApi\Response\SshKeyResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class SshKeys
 *
 * @package AcquiaCloudApi\CloudApi
 */
class SshKeys extends CloudApiBase implements CloudApiInterface
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
     * @param  string $keyId
     * @return SshKeyResponse
     */
    public function get($keyId): SshKeyResponse
    {
        return new SshKeyResponse(
            $this->client->request(
                'get',
                "/account/ssh-keys/${keyId}"
            )
        );
    }

    /**
     * Create an SSH key.
     *
     * @param  string $label
     * @param  string $public_key
     * @return OperationResponse
     */
    public function create($label, $public_key): OperationResponse
    {

        $options = [
            'json' => [
                'label' => $label,
                'public_key' => $public_key
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/account/ssh-keys", $options)
        );
    }

    /**
     * Delete a specific key by ID.
     *
     * @param  string  $keyId
     * @return OperationResponse
     */
    public function delete($keyId): OperationResponse
    {
        return new OperationResponse(
            $this->client->request('delete', "/account/ssh-keys/${keyId}")
        );
    }
}
