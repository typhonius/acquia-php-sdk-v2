<?php

namespace AcquiaCloudApi\Response;

/**
 * Class TagResponse
 *
 * @package AcquiaCloudApi\Response
 */
class TagResponse
{

    public $name;
    public $color;
    public $context;
    public $links;

    /**
     * TagResponse constructor.
     *
     * @param object $tag
     */
    public function __construct($tag)
    {
        $this->name = $tag->name;
        $this->color = $tag->color;
        $this->context = $tag->context;
        $this->links = $tag->_links;
    }
}
