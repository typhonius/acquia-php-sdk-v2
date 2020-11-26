<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<InvitationResponse>
 */
class InvitationsResponse extends CollectionResponse
{

    /**
     * @param array<object> $invitations
     */
    public function __construct($invitations)
    {
        parent::__construct('InvitationResponse', $invitations);
    }
}
