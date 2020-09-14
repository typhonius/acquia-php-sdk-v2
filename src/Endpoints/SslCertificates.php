<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Response\SslCertificatesResponse;
use AcquiaCloudApi\Response\SslCertificateResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class SslCertificates
 *
 * @package AcquiaCloudApi\CloudApi
 */
class SslCertificates extends CloudApiBase implements CloudApiInterface
{

    /**
     * Returns a list of SSL certificates.
     *
     * @param  string $environmentUuid The environment ID
     * @return SslCertificatesResponse
     */
    public function getAll($environmentUuid)
    {
        return new SslCertificatesResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/ssl/certificates"
            )
        );
    }

    /**
     * Returns a specific certificate by certificate ID.
     *
     * @param  string $environmentUuid The environment ID
     * @param  int    $certificateId
     * @return SslCertificateResponse
     */
    public function get($environmentUuid, $certificateId)
    {
        return new SslCertificateResponse(
            $this->client->request(
                'get',
                "/environments/${environmentUuid}/ssl/certificates/${certificateId}"
            )
        );
    }

    /**
     * Install an SSL certificate.
     *
     * @param  string $envUuid
     * @param  string $label
     * @param  string $cert
     * @param  string $key
     * @param  string $ca
     * @param  int    $csr
     * @param  bool   $legacy
     * @return OperationResponse
     */
    public function create($envUuid, $label, $cert, $key, $ca = null, $csr = null, $legacy = false)
    {

        $options = [
            'json' => [
                'label' => $label,
                'certificate' => $cert,
                'private_key' => $key,
                'ca_certificates' => $ca,
                'csr_id' => $csr,
                'legacy' => $legacy
            ],
        ];

        return new OperationResponse(
            $this->client->request('post', "/environments/${envUuid}/ssl/certificates", $options)
        );
    }

    /**
     * Delete a specific certificate by ID.
     *
     * @param  string $environmentUuid
     * @param  int    $certificateId
     * @return OperationResponse
     */
    public function delete($environmentUuid, $certificateId)
    {
        return new OperationResponse(
            $this->client->request('delete', "/environments/${environmentUuid}/ssl/certificates/${certificateId}")
        );
    }

    /**
     * Deactivates an active SSL certificate.
     *
     * @param  string $environmentUuid
     * @param  int    $certificateId
     * @return OperationResponse
     */
    public function disable($environmentUuid, $certificateId)
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentUuid}/ssl/certificates/${certificateId}/actions/deactivate"
            )
        );
    }

    /**
     * Activates an SSL certificate.
     *
     * @param  string $environmentUuid
     * @param  int    $certificateId
     * @return OperationResponse
     */
    public function enable($environmentUuid, $certificateId)
    {
        return new OperationResponse(
            $this->client->request(
                'post',
                "/environments/${environmentUuid}/ssl/certificates/${certificateId}/actions/activate"
            )
        );
    }
}
