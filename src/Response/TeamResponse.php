<?php

namespace AcquiaCloudApi\Response;

/**
 * Class TeamResponse
 * @package AcquiaCloudApi\Response
 */
class TeamResponse
{
    public $uuid;
    public $name;
    public $created_at;
    public $updated_at;
    public $organization;
    public $links;

    /**
     * TeamResponse constructor.
     * @param object $team
     */
    public function __construct($team)
    {
        $this->uuid = $team->uuid;
        $this->name = $team->name;
        $this->created_at = $team->created_at;
        $this->updated_at = $team->updated_at;
        $this->organization = $team->organization;
        $this->links = $team->_links;

    }
}