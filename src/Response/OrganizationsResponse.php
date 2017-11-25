<?php

namespace AcquiaCloudApi\Response;

/**
 * Class OrganizationsResponse
 * @package AcquiaCloudApi\Response
 */
class OrganizationsResponse extends \ArrayObject
{

    /**
     * OrganizationsResponse constructor.
     * @param array $organizations
     */
    public function __construct($organizations)
    {
        parent::__construct(array_map(function ($organization) {
            return new OrganizationResponse($organization);
        }, $organizations), self::ARRAY_AS_PROPS);
    }
}
