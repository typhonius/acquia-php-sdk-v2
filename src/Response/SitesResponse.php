<?php

namespace AcquiaCloudApi\Response;

use ArrayObject;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\SiteResponse>
 */
class SitesResponse extends ArrayObject
{
    /**
     * @param array<object> $sites
     */
    public function __construct(array $sites)
    {
        parent::__construct(
            array_map(
                static function ($site) {
                    return new SiteResponse($site);
                },
                $sites
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
