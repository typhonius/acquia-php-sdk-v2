<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\IdeResponse>
 */
class IdesResponse extends \ArrayObject
{
    /**
     * @param array<object> $ides
     */
    public function __construct(array $ides)
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
