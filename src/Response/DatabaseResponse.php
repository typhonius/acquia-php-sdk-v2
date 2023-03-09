<?php

namespace AcquiaCloudApi\Response;

class DatabaseResponse
{
    public string $name;
    public string $user_name;
    public string $password;
    public string $url;
    public string $db_host;
    public string $ssh_host;
    public object $flags;
    public object $environment;

    public function __construct(object $database)
    {
        $this->name = $database->name;
        $this->user_name = $database->user_name;
        $this->password = $database->password;
    }
}
