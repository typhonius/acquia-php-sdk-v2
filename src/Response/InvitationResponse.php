<?php

namespace AcquiaCloudApi\Response;

class InvitationResponse
{
    public string $uuid;

    public string $email;

    public MemberResponse $author;

    public object $applications;

    public object $organization;

    /**
     * @var array<object> $roles
     */
    public array $roles;

    public TeamResponse $team;

    public string $created_at;

    public string $token;

    public object $flags;

    public object $links;

    /**
     */
    public function __construct(object $invitation)
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
