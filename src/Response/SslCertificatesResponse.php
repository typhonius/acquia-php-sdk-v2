<?php

namespace AcquiaCloudApi\Response;

/**
 * Class CertificatesResponse
 *
 * @package AcquiaCloudApi\Response
 */
class SslCertificatesResponse extends \ArrayObject
{

    /**
     * CertificatesResponse constructor.
     *
     * @param array $certificates
     */
    public function __construct($certificates)
    {
        parent::__construct(
            array_map(
                function ($certificate) {
                    return new SslCertificateResponse($certificate);
                },
                $certificates
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
