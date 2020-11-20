<?php

namespace AcquiaCloudApi\Response;

/**
 * @template TValue
 * @template-extends \ArrayObject<int,TValue>
 */
class OrganizationsResponse extends \ArrayObject
{

    /**
     * @param array<object> $organizations
     */
    public function __construct($organizations)
    {
        parent::__construct(
            array_map(
                function ($organization) {
                    return new OrganizationResponse($organization);
                },
                $organizations
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
