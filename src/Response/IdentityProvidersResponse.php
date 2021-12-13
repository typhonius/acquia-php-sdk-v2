<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\IdentityProviderResponse>
 */
class IdentityProvidersResponse extends \ArrayObject
{
    /**
     * @param array<object> $idps
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
