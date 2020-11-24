<?php

namespace AcquiaCloudApi\Response;

/**
 * @template TValue
 * @template-extends \ArrayObject<int,TValue>
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
