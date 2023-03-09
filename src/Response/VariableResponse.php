<?php

namespace AcquiaCloudApi\Response;

class VariableResponse
{
    public string $name;

    public string $value;

    public object $links;

    public function __construct(object $variable)
    {
        $this->name = $variable->name;
        $this->value = $variable->value;
        $this->links = $variable->_links;
    }
}
