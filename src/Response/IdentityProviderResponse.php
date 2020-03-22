<?php

namespace AcquiaCloudApi\Response;

/**
 * Class IdentityProviderResponse
 *
 * @package AcquiaCloudApi\Response
 */
class IdentityProviderResponse
{

    public $uuid;
    public $label;
    public $idp_entity_id;
    public $sp_entity_id;
    public $sso_url;
    public $certificate;
    public $status;
    public $links;

    /**
     * IdentityProviderResponse constructor.
     *
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
