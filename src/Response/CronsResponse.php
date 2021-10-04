<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\CronResponse>
 */
class CronsResponse extends \ArrayObject
{

    /**
     * @param array<object> $crons
     */
    public function __construct($crons)
    {
        parent::__construct(
            array_map(
                function ($cron) {
                    return new CronResponse($cron);
                },
                $crons
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
