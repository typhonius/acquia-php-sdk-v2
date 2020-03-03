<?php

namespace AcquiaCloudApi\Response;

/**
 * Class IdentityProvidersResponse
 *
 * @package AcquiaCloudApi\Response
 */
class IdentityProvidersResponse extends \ArrayObject
{

    /**
     * IdentityProvidersResponse constructor.
     *
     * @param array $idps
     */
    public function __construct($idps)
    {
        parent::__construct(
            array_map(
                function ($idp) {
                    return new IdentityProviderResponse($idp);
                },
                $idps
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
