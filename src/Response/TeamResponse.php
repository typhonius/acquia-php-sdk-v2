<?php

namespace AcquiaCloudApi\Response;

class TeamResponse
{
    public string $uuid;

    public string $name;

    public ?string $created_at;

    public ?string $updated_at;

    public ?object $organization;

    public object $links;

    public function __construct(object $team)
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
