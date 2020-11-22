<?php

namespace AcquiaCloudApi\Response;

class CronResponse extends GenericResponse
{
    /**
     * @var string $id
     */
    public $id;

    /**
     * @var string $server
     */
    public $server;

    /**
     * @var string $command
     */
    public $command;

    /**
     * @var string $minute
     */
    public $minute;

    /**
     * @var string $hour
     */
    public $hour;

    /**
     * @var string $dayMonth
     */
    public $dayMonth;

    /**
     * @var string $month
     */
    public $month;

    /**
     * @var string $dayWeek
     */
    public $dayWeek;

    /**
     * @var string $label
     */
    public $label;

    /**
     * @var object $flags
     */
    public $flags;

    /**
     * @var object $environment
     */
    public $environment;

    /**
     * @var object $links
     */
    public $links;

    /**
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
