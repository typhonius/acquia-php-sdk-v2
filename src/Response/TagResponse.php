<?php

namespace AcquiaCloudApi\Response;

class TagResponse
{
    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $color
     */
    public $color;

    /**
     * @var object $context
     */
    public $context;

    /**
     * @var object $links
     */
    public $links;

    /**
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
