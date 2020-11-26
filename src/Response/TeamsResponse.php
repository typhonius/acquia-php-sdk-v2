<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<TeamResponse>
 */
class TeamsResponse extends CollectionResponse
{

    /**
     * @param array<object> $teams
     */
    public function __construct($teams)
    {
        parent::__construct('TeamResponse', $teams);
    }
}
