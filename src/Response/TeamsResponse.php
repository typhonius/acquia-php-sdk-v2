<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\TeamResponse>
 */
class TeamsResponse extends \ArrayObject
{

    /**
     * @param array<object> $teams
     */
    public function __construct($teams)
    {
        parent::__construct(
            array_map(
                function ($team) {
                    return new TeamResponse($team);
                },
                $teams
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
