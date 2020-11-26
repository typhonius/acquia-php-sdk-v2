<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<SslCertificateResponse>
 */
class SslCertificatesResponse extends CollectionResponse
{

    /**
     * @param array<object> $certificates
     */
    public function __construct($certificates)
    {
        parent::__construct('SslCertificateResponse', $certificates);
    }
}
