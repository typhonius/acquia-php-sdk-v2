<?php

namespace AcquiaCloudApi\Response;

/**
 * Class InvitationResponse
 * @package AcquiaCloudApi\Response
 */
class InvitationResponse
{
    public $uuid;
    public $email;
    public $author;
    public $applications;
    public $organization;
    public $roles;
    public $team;
    public $created_at;
    public $token;
    public $flags;
    public $links;

    /**
     * MemberResponse constructor.
     * @param object $invitation
     */
    public function __construct($invitation)
    {
        $this->uuid = $invitation->uuid;
        $this->email = $invitation->email;
        $this->author = new MemberResponse($invitation->author);
        $this->applications = $invitation->applications;
        $this->organization = $invitation->organization;
        $this->roles = $invitation->roles;
        $this->team = new TeamResponse($invitation->team);
        $this->created_at = $invitation->created_at;
        $this->token = $invitation->token;
        $this->flags = $invitation->flags;
        $this->links = $invitation->_links;
    }
}
