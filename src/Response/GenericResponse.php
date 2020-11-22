<?php

namespace AcquiaCloudApi\Response;

use AcquiaCloudApi\Exception\NoLinkedResourceException;
use AcquiaCloudApi\Exception\LinkedResourceNotFoundException;

abstract class GenericResponse
{

    /**
     * @param string $name
     * @return array{type:string, path:string}
     * @throws NoLinkedResourceException
     * @throws LinkedResourceNotFoundException
     */
    public function getLink(string $name)
    {
        if (!property_exists($this, 'links')) {
            throw new NoLinkedResourceException('No linked resources for ' . get_called_class());
        } elseif (!property_exists($this->links, $name)) {
            throw new LinkedResourceNotFoundException('No property exists for ' . $name . '. Available links are ' . implode(' ', array_keys(get_object_vars($this->links))));
        } elseif (!property_exists($this->links->$name, 'href')) {
            throw new LinkedResourceNotFoundException('href property not found on ' . $name);
        }
        return ['type' => $name, 'path' => $this->links->$name->href];
    }
}
