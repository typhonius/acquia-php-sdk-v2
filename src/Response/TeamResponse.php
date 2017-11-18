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
        if (property_exists($team, 'created_at')) {
            $this->created_at = $team->created_at;
        }
        if (property_exists($team, 'updated_at')) {
            $this->updated_at = $team->updated_at;
        }
        if (property_exists($team, 'organization')) {
            $this->organization = $team->organization;
        }
        if (property_exists($team, '_links')) {
            $this->links = $team->_links;
        }
    }
}
