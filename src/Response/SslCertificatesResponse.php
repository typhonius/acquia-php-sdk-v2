<?php

namespace AcquiaCloudApi\Response;

/**
 * @template TValue
 * @template-extends \ArrayObject<int,TValue>
 */
class SslCertificatesResponse extends \ArrayObject
{

    /**
     * @param array<object> $certificates
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
