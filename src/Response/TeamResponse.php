<?php

namespace AcquiaCloudApi\Response;

class TeamResponse
{
    /**
     * @var string $uuid
     */
    public $uuid;

    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string|null $created_at
     */
    public $created_at;

    /**
     * @var string|null $updated_at
     */
    public $updated_at;

    /**
     * @var object|null $organization
     */
    public $organization;

    /**
     * @var object $links
     */
    public $links;

    /**
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
