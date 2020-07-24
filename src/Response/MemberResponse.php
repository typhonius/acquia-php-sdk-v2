<?php

namespace AcquiaCloudApi\Response;

/**
 * Class MemberResponse
 *
 * @package AcquiaCloudApi\Response
 */
class MemberResponse
{
    public $uuid;
    public $teams;
    public $first_name;
    public $last_name;
    public $mail;
    public $picture_url;
    public $username;
    public $links;

    /**
     * MemberResponse constructor.
     *
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
        if (property_exists($member, '_links')) {
            $this->links = $member->_links;
        }
    }
}
