<?php

namespace AcquiaCloudApi\Response;

class InsightCountResponse
{
    public string $name;

    public int $pass;

    public int $fail;

    public int $ignored;

    public int $total;

    public int $percent;

    /**
     */
    public function __construct(string $name, object $insightCount)
    {
        $this->name = $name;
        $this->pass = $insightCount->pass;
        $this->fail = $insightCount->fail;
        $this->ignored = $insightCount->ignored;
        $this->total = $insightCount->total;
        $this->percent = $insightCount->percent;
    }
}
