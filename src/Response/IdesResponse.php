<?php

namespace AcquiaCloudApi\Response;

/**
 * Class IdesResponse
 *
 * @package AcquiaCloudApi\Response
 */
class IdesResponse extends \ArrayObject
{

    /**
     * IdesResponse constructor.
     *
     * @param array $ides
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
