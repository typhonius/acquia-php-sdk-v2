<?php

namespace AcquiaCloudApi\Response;

/**
 * Class MembersResponse
 * @package AcquiaCloudApi\Response
 */
class MembersResponse extends \ArrayObject
{

    /**
     * MembersResponse constructor.
     * @param array $members
     */
    public function __construct($members)
    {
        parent::__construct(array_map(function ($member) {
            return new MemberResponse($member);
        }, $members), self::ARRAY_AS_PROPS);
    }
}
