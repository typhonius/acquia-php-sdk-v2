<?php

namespace AcquiaCloudApi\Response;

class CronResponse
{
    public string $id;

    public ?object $server;

    public string $command;

    public string $minute;

    public string $hour;

    public string $dayMonth;

    public string $month;

    public string $dayWeek;

    public ?string $label;

    public object $flags;

    public object $environment;

    public object $links;

    /**
     */
    public function __construct(object $cron)
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
