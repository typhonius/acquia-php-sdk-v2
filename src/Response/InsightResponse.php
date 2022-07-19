<?php

namespace AcquiaCloudApi\Response;

use stdClass;

class InsightResponse extends GenericResponse
{
    /**
     * @var string $uuid
     */
    public $uuid;

    /**
     * @var string $label
     */
    public $label;

    /**
     * @var string $hostname
     */
    public $hostname;

    /**
     * @var string $status
     */
    public $status;

    /**
     * @var string $updatedAt
     */
    public $updatedAt;

    /**
     * @var string $lastConnectedAt
     */
    public $lastConnectedAt;

    /**
     * @var object $scores
     */
    public $scores;

    /**
     * @var object $counts
     */
    public $counts;

    /**
     * @var object $flags
     */
    public $flags;

    /**
     * @var object $links
     */
    public $links;

    /**
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
