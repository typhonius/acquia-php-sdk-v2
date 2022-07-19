<?php

namespace AcquiaCloudApi\Traits;

use AcquiaCloudApi\Exception\NoLinkedResourceException;
use AcquiaCloudApi\Exception\LinkedResourceNotFoundException;

/**
 * Trait LinkedResponseTrait
 *
 * @package AcquiaCloudApi\CloudApi
 */
trait LinkedResourceTrait
{

    /**
     * @param string $name
     * @return array{type:string, path:string, responseClass:class-string}
     * @throws NoLinkedResourceException
     * @throws LinkedResourceNotFoundException
     */
    public function getLink(string $name)
    {
        if (!property_exists($this, 'links')) {
            throw new NoLinkedResourceException('No linked resources for ' . get_called_class());
        } elseif (!property_exists($this->links, $name)) {
            throw new LinkedResourceNotFoundException('No property exists for ' . $name . '. Available links are ' . implode(' ', array_keys((array) $this->links)));
        } elseif (!property_exists($this->links->$name, 'href')) {
            throw new LinkedResourceNotFoundException('No href property exists for ' . $name);
        }

        return ['type' => $name, 'path' => $this->links->$name->href, 'responseClass' => get_class($this)];
    }
}
