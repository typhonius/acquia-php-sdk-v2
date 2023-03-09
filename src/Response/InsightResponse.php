<?php

namespace AcquiaCloudApi\Response;

use stdClass;

class InsightResponse
{
    public string $uuid;

    public string $label;

    public string $hostname;

    public string $status;

    public string $updatedAt;

    public string $lastConnectedAt;

    public object $scores;

    public object $counts;

    public object $flags;

    public object $links;

    public function __construct(object $insight)
    {
        $this->uuid = $insight->uuid;
        $this->label = $insight->label;
        $this->hostname = $insight->hostname;
        $this->status = $insight->status;
        $this->updatedAt = $insight->updated_at;
        $this->lastConnectedAt = $insight->last_connected_at;
        $this->scores = $insight->scores;
        $this->flags = $insight->flags;
        $this->links = $insight->_links;

        $scores = new stdClass();
        foreach ($insight->counts as $name => $counts) {
            $scores->$name = new InsightCountResponse($name, $counts);
        }
        $this->counts = $scores;
    }
}
