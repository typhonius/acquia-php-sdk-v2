<?php

namespace AcquiaCloudApi\Response;

/**
 * Class CronsResponse
 * @package AcquiaCloudApi\Response
 */
class CronsResponse extends \ArrayObject
{

    /**
     * CronsResponse constructor.
     * @param array $crons
     */
    public function __construct($crons)
    {
        parent::__construct(array_map(function ($cron) {
            return new CronResponse($cron);
        }, $crons), self::ARRAY_AS_PROPS);
    }
}
