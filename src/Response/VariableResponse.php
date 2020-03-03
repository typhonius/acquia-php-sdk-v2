<?php

namespace AcquiaCloudApi\Response;

/**
 * Class VariableResponse
 *
 * @package AcquiaCloudApi\Response
 */
class VariableResponse
{
    public $name;
    public $value;
    public $links;

    /**
     * VariableResponse constructor.
     *
     * @param object $variable
     */
    public function __construct($variable)
    {
        $this->name = $variable->name;
        $this->value = $variable->value;
        $this->links = $variable->_links;
    }
}
