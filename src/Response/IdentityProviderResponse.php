<?php

namespace AcquiaCloudApi\Response;

class IdentityProviderResponse
{
    public string $uuid;

    public string $label;

    public string $idp_entity_id;

    public string $sp_entity_id;

    public string $sso_url;

    public string $certificate;

    public string $status;

    public object $links;

    /**
     */
    public function __construct(object $idp)
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
