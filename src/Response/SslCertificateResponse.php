<?php

namespace AcquiaCloudApi\Response;

/**
 * Class CertificateResponse
 *
 * @package AcquiaCloudApi\Response
 */
class SslCertificateResponse
{
    /**
     * @var int $id
     */
    public $id;

    /**
     * @var string $label
     */
    public $label;

    /**
     * @var string $certificate
     */
    public $certificate;

    /**
     * @var string $private_key
     */
    public $private_key;

    /**
     * @var string $ca
     */
    public $ca;

    /**
     * @var object $flags
     */
    public $flags;

    /**
     * @var string $expires_at
     */
    public $expires_at;

    /**
     * @var array<string> $domains
     */
    public $domains;

    /**
     * @var object $environment
     */
    public $environment;

    /**
     * @var object $links
     */
    public $links;

    /**
     * CertificateResponse constructor.
     *
     * @param object $certificate
     */
    public function __construct($certificate)
    {
        $this->id = $certificate->id;
        $this->label = $certificate->label;
        $this->certificate = $certificate->certificate;
        $this->private_key = $certificate->private_key;
        $this->ca = $certificate->ca;
        $this->flags = $certificate->flags;
        $this->expires_at = $certificate->expires_at;
        $this->domains = $certificate->domains;
        $this->environment = $certificate->environment;
        $this->links = $certificate->_links;
    }
}
