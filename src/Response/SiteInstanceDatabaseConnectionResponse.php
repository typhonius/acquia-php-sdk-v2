<?php

namespace AcquiaCloudApi\Response;

class SiteInstanceDatabaseConnectionResponse
{
    public string $databaseHost;

    public string $databaseName;

    public string $databasePassword;

    public string $databaseUserName;

    public string $sshHost;

    public object $links;

    public function __construct(object $database)
    {
        $this->databaseHost = $database->db_host;
        $this->databaseName = $database->name;
        $this->databasePassword = $database->password;
        $this->databaseUserName = $database->user_name;
        $this->sshHost = $database->ssh_host;
        $this->links = $database->_links;
    }
}
