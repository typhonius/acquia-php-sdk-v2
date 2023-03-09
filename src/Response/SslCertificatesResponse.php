<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\SslCertificateResponse>
 */
class SslCertificatesResponse extends \ArrayObject
{
    /**
     * @param array<object> $certificates
     */
    public function __construct(array $certificates)
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
