<?php

namespace AcquiaCloudApi\Response;

/**
 * @template TValue
 * @template-extends \ArrayObject<int,TValue>
 */
class IdesResponse extends \ArrayObject
{

    /**
     * @param array<object> $ides
     */
    public function __construct($ides)
    {
        parent::__construct(
            array_map(
                function ($ide) {
                    return new IdeResponse($ide);
                },
                $ides
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
