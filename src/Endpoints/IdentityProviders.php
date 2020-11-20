<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\OperationResponse;
use AcquiaCloudApi\Response\IdentityProvidersResponse;
use AcquiaCloudApi\Response\IdentityProviderResponse;

/**
 * Class IdentityProviders
 *
 * @package AcquiaCloudApi\CloudApi
 */
class IdentityProviders extends CloudApiBase implements CloudApiInterface
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
     * @param  string $idpUuid The identity provider ID
     * @return IdentityProviderResponse
     */
    public function get($idpUuid): IdentityProviderResponse
    {
        return new IdentityProviderResponse(
            $this->client->request(
                'get',
                "/identity-providers/${idpUuid}"
            )
        );
    }

    /**
     * Delete a specific identity provider by UUID.
     *
     * @param  string $idpUuid
     * @return OperationResponse
     */
    public function delete($idpUuid): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'delete',
                "/identity-providers/${idpUuid}"
            )
        );
    }

    /**
     * Disables an identity provider by UUID.
     *
     * @param  string $idpUuid
     * @return OperationResponse
     */
    public function disable($idpUuid): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/identity-providers/${idpUuid}/actions/disable"
            )
        );
    }

    /**
     * Enables an identity provider by UUID.
     *
     * @param  string $idpUuid
     * @return OperationResponse
     */
    public function enable($idpUuid): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/identity-providers/${idpUuid}/actions/enable"
            )
        );
    }

    /**
     * Updates a identity provider by UUID.
     *
     * @param  string $idpUuid
     * @param  string $label
     * @param  string $entityId
     * @param  string $ssoUrl
     * @param  string $certificate
     * @return OperationResponse
     */
    public function update($idpUuid, $label, $entityId, $ssoUrl, $certificate): OperationResponse
    {

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
                "/identity-providers/${idpUuid}",
                $options
            )
        );
    }
}
