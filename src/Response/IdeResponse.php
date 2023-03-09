<?php

namespace AcquiaCloudApi\Response;

class IdeResponse
{
    public string $uuid;

    public string $label;

    public object $links;

    public MemberResponse $owner;

    public function __construct(object $ide)
    {
        $this->uuid = $ide->uuid;
        $this->label = $ide->label;
        $this->links = $ide->_links;
        if (isset($ide->_embedded->owner)) {
            $this->owner = new MemberResponse($ide->_embedded->owner);
        }
    }
}
