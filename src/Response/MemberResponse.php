<?php

namespace AcquiaCloudApi\Response;

class MemberResponse
{
    public string $uuid;

    /**
     * @var TeamsResponse<TeamResponse>|null $teams
     */
    public ?TeamsResponse $teams;

    public string $first_name;

    public string $last_name;

    public ?string $mail;

    public string $picture_url;

    public string $username;

    public ?object $flags;

    public ?object $links;

    public function __construct(object $member)
    {
        $this->uuid = $member->uuid;
        $this->first_name = $member->first_name;
        $this->last_name = $member->last_name;

        if (property_exists($member, 'mail')) {
            $this->mail = $member->mail;
        } elseif (property_exists($member, 'email')) {
            $this->mail = $member->email;
        }
        $this->picture_url = $member->picture_url;
        $this->username = $member->username;

        if (property_exists($member, 'teams')) {
            $this->teams = new TeamsResponse($member->teams);
        }
        if (property_exists($member, 'flags')) {
            $this->links = $member->flags;
        }
        if (property_exists($member, '_links')) {
            $this->links = $member->_links;
        }
    }
}
