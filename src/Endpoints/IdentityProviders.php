<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\IdentityProviderResponse;
use AcquiaCloudApi\Response\IdentityProvidersResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class IdentityProviders
 *
 * @package AcquiaCloudApi\CloudApi
 */
class IdentityProviders extends CloudApiBase
{
    /**
     * Returns a list of identity providers for the user.
     *
     * @return IdentityProvidersResponse<IdentityProviderResponse>
     */
    public function getAll(): IdentityProvidersResponse
    {
        return new IdentityProvidersResponse(
            $this->client->request(
                'get',
                "/identity-providers"
            )
        );
    }

    /**
     * Returns a specific identity provider by UUID.
     *
     * @param string $idpUuid The identity provider ID
     *
     */
    public function get(string $idpUuid): IdentityProviderResponse
    {
        return new IdentityProviderResponse(
            $this->client->request(
                'get',
                "/identity-providers/$idpUuid"
            )
        );
    }

    /**
     * Delete a specific identity provider by UUID.
     *
     *
     */
    public function delete(string $idpUuid): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'delete',
                "/identity-providers/$idpUuid"
            )
        );
    }

    /**
     * Disables an identity provider by UUID.
     *
     *
     */
    public function disable(string $idpUuid): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/identity-providers/$idpUuid/actions/disable"
            )
        );
    }

    /**
     * Enables an identity provider by UUID.
     *
     *
     */
    public function enable(string $idpUuid): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/identity-providers/$idpUuid/actions/enable"
            )
        );
    }

    /**
     * Updates a identity provider by UUID.
     *
     *
     */
    public function update(
        string $idpUuid,
        string $label,
        string $entityId,
        string $ssoUrl,
        string $certificate
    ): OperationResponse {

        $options = [
            'json' => [
                'label' => $label,
                'entity_id' => $entityId,
                'sso_url' => $ssoUrl,
                'certificate' => $certificate,
            ],
        ];

        return new OperationResponse(
            $this->client->request(
                'put',
                "/identity-providers/$idpUuid",
                $options
            )
        );
    }
}
