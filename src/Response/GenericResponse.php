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
            throw new LinkedResourceNotFoundException('No property exists for ' . $name . '. Available links are ' . implode(' ', array_keys((array) $this->links)));
        }

        /**
         * Because the name of the property within the $links->property->$name object may change, we must avoid accessing it directly.
         * The below converts the object into an array, obtains the values directly (bypassing the need to know the key),
         * and retrieves the first (and only) item from the resultant array which will be our linked resource path.
         */
        $path = current(array_values((array) $this->links->$name));
        return ['type' => $name, 'path' => $path];
    }
}
