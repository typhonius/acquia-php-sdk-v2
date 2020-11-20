<?php

namespace AcquiaCloudApi\Response;

class MemberResponse
{
    /**
     * @var string $uuid
     */
    public $uuid;

    /**
     * @var TeamsResponse<TeamResponse>|null $teams
     */
    public $teams;

    /**
     * @var string $first_name
     */
    public $first_name;

    /**
     * @var string $last_name
     */
    public $last_name;

    /**
     * @var string|null $mail
     */
    public $mail;

    /**
     * @var string $picture_url
     */
    public $picture_url;

    /**
     * @var string $username
     */
    public $username;

    /**
     * @var object|null $flags
     */
    public $flags;

    /**
     * @var object|null $links
     */
    public $links;

    /**
     * @param object $member
     */
    public function __construct($member)
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
