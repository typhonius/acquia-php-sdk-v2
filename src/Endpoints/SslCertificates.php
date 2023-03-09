<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\OperationResponse;
use AcquiaCloudApi\Response\SslCertificateResponse;
use AcquiaCloudApi\Response\SslCertificatesResponse;

/**
 * Class SslCertificates
 *
 * @package AcquiaCloudApi\CloudApi
 */
class SslCertificates extends CloudApiBase
{
    /**
     * Returns a list of SSL certificates.
     *
     * @param string $environmentUuid The environment ID
     *
     * @return SslCertificatesResponse<SslCertificateResponse>
     */
    public function getAll(string $environmentUuid): SslCertificatesResponse
    {
        return new SslCertificatesResponse(
            $this->client->request(
                'get',
                "/environments/$environmentUuid/ssl/certificates"
            )
        );
    }

    /**
     * Returns a specific certificate by certificate ID.
     *
     * @param string $environmentUuid The environment ID
     *
     */
    public function get(string $environmentUuid, int $certificateId): SslCertificateResponse
    {
        return new SslCertificateResponse(
            $this->client->request(
                'get',
                "/environments/$environmentUuid/ssl/certificates/$certificateId"
            )
        );
    }

    /**
     * Install an SSL certificate.
     *
     * @param string|null $ca
     * @param int|null $csr
     *
     */
    public function create(
        string $envUuid,
        string $label,
        string $cert,
        string $key,
        string $ca = null,
        int $csr = null,
        bool $legacy = false
    ): OperationResponse {

        $options = [
            'json' => [
                'label' => $label,
                'certificate' => $cert,
                'private_key' => $key,
                'ca_certificates' => $ca,
                'csr_id' => $csr,
                'legacy' => $legacy,
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/environments/$envUuid/ssl/certificates", $options)
        );
    }

    /**
     * Delete a specific certificate by ID.
     *
     *
     */
    public function delete(string $environmentUuid, int $certificateId): OperationResponse
    {
        return new OperationResponse(
            $this->client->request('delete', "/environments/$environmentUuid/ssl/certificates/$certificateId")
        );
    }

    /**
     * Deactivates an active SSL certificate.
     *
     *
     */
    public function disable(string $environmentUuid, int $certificateId): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/$environmentUuid/ssl/certificates/$certificateId/actions/deactivate"
            )
        );
    }

    /**
     * Activates an SSL certificate.
     *
     *
     */
    public function enable(string $environmentUuid, int $certificateId): OperationResponse
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/$environmentUuid/ssl/certificates/$certificateId/actions/activate"
            )
        );
    }
}
