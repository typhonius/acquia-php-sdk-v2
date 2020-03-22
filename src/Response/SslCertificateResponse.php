<?php

namespace AcquiaCloudApi\Response;

/**
 * Class CertificateResponse
 *
 * @package AcquiaCloudApi\Response
 */
class SslCertificateResponse
{

    public $id;
    public $label;
    public $certificate;
    public $private_key;
    public $ca;
    public $flags;
    public $expires_at;
    public $domains;
    public $environment;
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
