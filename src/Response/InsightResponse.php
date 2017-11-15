<?php

namespace AcquiaCloudApi\Response;

/**
 * Class InsightResponse
 * @package AcquiaCloudApi\Response
 */
class InsightResponse
{

    public $label;
    public $hostname;
    public $status;
    public $scores;
    public $counts;
    public $flags;
    public $links;

    /**
     * InsightResponse constructor.
     * @param object $insight
     */
    public function __construct($insight)
    {
        $this->label = $insight->label;
        $this->hostname = $insight->hostname;
        $this->status = $insight->status;
        $this->scores = $insight->scores;
        $this->flags = $insight->flags;
        $this->links = $insight->_links;

        $scores = new \stdClass();
        foreach ($insight->counts as $name => $counts) {
            $scores->$name = new InsightCountResponse($name, $counts);
        }
        $this->counts = $scores;
    }
}
