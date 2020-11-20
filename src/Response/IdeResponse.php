<?php

namespace AcquiaCloudApi\Response;

class IdeResponse
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
     * @var object $links
     */
    public $links;

    /**
     * @var MemberResponse $owner
     */
    public $owner;

    /**
     * @param object $ide
     */
    public function __construct($ide)
    {
        $this->uuid = $ide->uuid;
        $this->label = $ide->label;
        $this->links = $ide->_links;
        $this->owner = new MemberResponse($ide->_embedded->owner);
    }
}
