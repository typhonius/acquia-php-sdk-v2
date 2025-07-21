<?php

namespace AcquiaCloudApi\Response;

use ArrayObject;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\ReferenceResponse>
 */
class ReferencesResponse extends ArrayObject
{
    /**
     * @param array<object> $references
     */
    public function __construct(array $references)
    {
        parent::__construct(
            array_map(
                static function ($reference) {
                    return new ReferenceResponse($reference);
                },
                $references
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
