<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\MemberResponse>
 */
class MembersResponse extends \ArrayObject
{
    /**
     * @param array<object> $members
     */
    public function __construct(array $members)
    {
        parent::__construct(
            array_map(
                static function ($member) {
                    return new MemberResponse($member);
                },
                $members
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
