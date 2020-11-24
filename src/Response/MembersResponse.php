<?php

namespace AcquiaCloudApi\Response;

/**
 * @template TValue
 * @template-extends \ArrayObject<int,TValue>
 */
class MembersResponse extends \ArrayObject
{

    /**
     * @param array<object> $members
     */
    public function __construct($members)
    {
        parent::__construct(
            array_map(
                function ($member) {
                    return new MemberResponse($member);
                },
                $members
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
