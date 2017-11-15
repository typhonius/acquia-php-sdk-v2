<?php

namespace AcquiaCloudApi\Response;

/**
 * Class InsightCountResponse
 * @package AcquiaCloudApi\Response
 */
class InsightCountResponse
{

    public $name;
    public $pass;
    public $fail;
    public $ignored;
    public $total;
    public $percent;

    /**
     * InsightCountResponse constructor.
     * @param string $name
     * @param object $insightCount
     */
    public function __construct($name, $insightCount)
    {
        $this->name = $name;
        $this->pass = $insightCount->pass;
        $this->fail = $insightCount->fail;
        $this->ignored = $insightCount->ignored;
        $this->total = $insightCount->total;
        $this->percent = $insightCount->percent;
    }
}
