<?php

namespace AcquiaCloudApi\Response;

/**
 * Class CronResponse
 * @package AcquiaCloudApi\Response
 */
class CronResponse
{

    public $id;
    public $server;
    public $command;
    public $minute;
    public $hour;
    public $dayMonth;
    public $month;
    public $dayWeek;
    public $label;
    public $flags;
    public $environment;
    public $links;

    /**
     * CronResponse constructor.
     * @param object $cron
     */
    public function __construct($cron)
    {
        $this->id = $cron->id;
        $this->server = $cron->server;
        $this->command = $cron->command;
        $this->minute = $cron->minute;
        $this->hour = $cron->hour;
        $this->dayMonth = $cron->day_month;
        $this->month = $cron->month;
        $this->dayWeek = $cron->day_week;
        $this->label = $cron->label;
        $this->flags = $cron->flags;
        $this->environment = $cron->environment;
        $this->links = $cron->_links;
    }
}
