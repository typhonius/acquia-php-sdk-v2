<?php

namespace AcquiaCloudApi\Response;

/**
 * Class CertificateResponse
 *
 * @package AcquiaCloudApi\Response
 */
class SslCertificateResponse
{
    public int $id;

    public ?string $label;

    public string $certificate;

    public ?string $private_key;

    public string $ca;

    public object $flags;

    public string $expires_at;

    /**
     * @var array<string> $domains
     */
    public array $domains;

    public object $environment;

    public object $links;

    /**
     * CertificateResponse constructor.
     */
    public function __construct(object $certificate)
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
