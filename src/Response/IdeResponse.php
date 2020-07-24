<?php

namespace AcquiaCloudApi\Response;

/**
 * Class IdeResponse
 *
 * @package AcquiaCloudApi\Response
 */
class IdeResponse
{
    public $uuid;
    public $label;
    public $links;
    public $owner;

    /**
     * IdeResponse constructor.
     *
     * @param object $ide
     */
    public function __construct($ide)
    {
        $this->uuid = $ide->uuid;
        $this->label = $ide->label;
        $this->links = $ide->_links;
        $this->owner = $ide->_embedded->owner;
    }
}
