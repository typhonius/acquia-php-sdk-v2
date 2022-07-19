<?php

namespace AcquiaCloudApi\Response;

class InsightCountResponse extends GenericResponse
{
    /**
     * @var string $name
     */
    public $name;

    /**
     * @var int $pass
     */
    public $pass;

    /**
     * @var int $fail
     */
    public $fail;

    /**
     * @var int $ignored
     */
    public $ignored;

    /**
     * @var int $total
     */
    public $total;

    /**
     * @var int $percent
     */
    public $percent;

    /**
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
