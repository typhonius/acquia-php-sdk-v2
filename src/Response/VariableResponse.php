<?php

namespace AcquiaCloudApi\Response;

class VariableResponse extends GenericResponse
{
    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $value
     */
    public $value;

    /**
     * @var object $links
     */
    public $links;

    /**
     * @param object $variable
     */
    public function __construct($variable)
    {
        $this->name = $variable->name;
        $this->value = $variable->value;
        $this->links = $variable->_links;
    }
}
