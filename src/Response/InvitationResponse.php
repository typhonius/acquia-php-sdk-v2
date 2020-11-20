<?php

namespace AcquiaCloudApi\Response;

class InvitationResponse
{
    /**
     * @var string $uuid
     */
    public $uuid;

    /**
     * @var string $email
     */
    public $email;

    /**
     * @var MemberResponse $author
     */
    public $author;

    /**
     * @var object $applications
     */
    public $applications;

    /**
     * @var object $organization
     */
    public $organization;

    /**
     * @var array<object> $roles
     */
    public $roles;

    /**
     * @var TeamResponse $team
     */
    public $team;

    /**
     * @var string $created_at
     */
    public $created_at;

    /**
     * @var string $token
     */
    public $token;

    /**
     * @var object $flags
     */
    public $flags;

    /**
     * @var object $links
     */
    public $links;

    /**
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
