<?php

namespace AcquiaCloudApi\Response;

class TagResponse
{
    public string $name;

    public string $color;

    public object $context;

    public object $links;

    public function __construct(object $tag)
    {
        $this->name = $tag->name;
        $this->color = $tag->color;
        $this->context = $tag->context;
        $this->links = $tag->_links;
    }
}
