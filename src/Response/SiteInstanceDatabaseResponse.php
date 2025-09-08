<?php

namespace AcquiaCloudApi\Response;

class SiteInstanceDatabaseResponse
{
    public string $databaseHost;

    public string $databaseName;

    public string $databaseRole;

    public string $databaseUserName;

    public string $databasePassword;

    public object $links;

    public function __construct(object $database)
    {
        $this->databaseHost = $database->database_host;
        $this->databaseName = $database->database_name;
        $this->databaseRole = $database->database_role;
        $this->databaseUserName = $database->database_user_name;
        $this->databasePassword = $database->database_password;
        $this->links = $database->_links;
    }
}
