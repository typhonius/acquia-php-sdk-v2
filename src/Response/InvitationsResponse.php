<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\InvitationResponse>
 */
class InvitationsResponse extends \ArrayObject
{

    /**
     * @param array<object> $invitations
     */
    public function __construct($invitations)
    {
        parent::__construct(
            array_map(
                function ($invitation) {
                    return new InvitationResponse($invitation);
                },
                $invitations
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
