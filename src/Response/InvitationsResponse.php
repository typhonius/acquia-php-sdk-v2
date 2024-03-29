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
    public function __construct(array $invitations)
    {
        parent::__construct(
            array_map(
                static function ($invitation) {
                    return new InvitationResponse($invitation);
                },
                $invitations
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
