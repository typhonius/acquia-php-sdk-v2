<?php

namespace AcquiaCloudApi\Response;

class IdentityProviderResponse
{
    /**
     * @var string $uuid
     */
    public $uuid;

    /**
     * @var string $label
     */
    public $label;

    /**
     * @var string $idp_entity_id
     */
    public $idp_entity_id;

    /**
     * @var string $sp_entity_id
     */
    public $sp_entity_id;

    /**
     * @var string $sso_url
     */
    public $sso_url;

    /**
     * @var string $certificate
     */
    public $certificate;

    /**
     * @var string $status
     */
    public $status;

    /**
     * @var object $links
     */
    public $links;

    /**
     * @param object $idp
     */
    public function __construct($idp)
    {
        $this->uuid = $idp->uuid;
        $this->label = $idp->label;
        $this->idp_entity_id = $idp->idp_entity_id;
        $this->sp_entity_id = $idp->sp_entity_id;
        $this->sso_url = $idp->sso_url;
        $this->certificate = $idp->certificate;
        $this->status = $idp->status;
        $this->links = $idp->_links;
    }
}
