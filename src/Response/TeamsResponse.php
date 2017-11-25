<?php

namespace AcquiaCloudApi\Response;

/**
 * Class TeamsResponse
 * @package AcquiaCloudApi\Response
 */
class TeamsResponse extends \ArrayObject
{

    /**
     * TeamsResponse constructor.
     * @param array $teams
     */
    public function __construct($teams)
    {
        parent::__construct(array_map(function ($team) {
            return new TeamResponse($team);
        }, $teams), self::ARRAY_AS_PROPS);
    }
}
