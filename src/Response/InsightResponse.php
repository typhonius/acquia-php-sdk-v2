<?php

namespace AcquiaCloudApi\Response;

use stdClass;

/**
 * Class InsightResponse
 *
 * @package AcquiaCloudApi\Response
 */
class InsightResponse
{

    public $uuid;
    public $label;
    public $hostname;
    public $status;
    public $updatedAt;
    public $lastConnectedAt;
    public $scores;
    public $counts;
    public $flags;
    public $links;

    /**
     * InsightResponse constructor.
     *
     * @param object $insight
     */
    public function __construct($insight)
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
