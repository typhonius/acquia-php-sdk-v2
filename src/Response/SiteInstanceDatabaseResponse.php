<?php

namespace AcquiaCloudApi\Response;

class SiteInstanceDatabaseResponse
{
    public string $databaseHost;

    public string $databaseName;

    public string $databaseRole;

    public string $databaseUser;

    public string $databasePassword;

    public int $databasePort;

    public object $links;

    public function __construct(object $database)
    {
        $this->databaseHost = $database->database_host;
        $this->databaseName = $database->database_name;
        $this->databaseRole = $database->database_role;
        $this->databaseUser = $database->database_user;
        $this->databasePassword = $database->database_password;
        $this->databasePort = $database->database_port;
        $this->links = $database->_links;
    }
}
