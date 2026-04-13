<?php

namespace AcquiaCloudApi\Response;

class SiteInstanceDatabaseResponse
{
    public string $databaseName;

    public string $databaseRole;

    public object $links;

    public function __construct(object $database)
    {
        $this->databaseName = $database->database_name;
        $this->databaseRole = $database->database_role;
        $this->links = $database->_links;
    }
}
