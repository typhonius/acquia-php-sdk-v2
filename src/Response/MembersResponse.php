<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<MemberResponse>
 */
class MembersResponse extends CollectionResponse
{

    /**
     * @param array<object> $members
     */
    public function __construct($members)
    {
        parent::__construct('MemberResponse', $members);
    }
}
