<?php

namespace AcquiaCloudApi\Response;

/**
 * Class InvitationsResponse
 * @package AcquiaCloudApi\Response
 */
class InvitationsResponse extends \ArrayObject
{

    /**
     * MembersResponse constructor.
     * @param array $invitations
     */
    public function __construct($invitations)
    {
        parent::__construct(array_map(function ($invitation) {
            return new InvitationResponse($invitation);
        }, $invitations), self::ARRAY_AS_PROPS);
    }
}
