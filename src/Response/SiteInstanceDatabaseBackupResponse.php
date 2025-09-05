<?php

namespace AcquiaCloudApi\Response;

class SiteInstanceDatabaseBackupResponse
{
    public string $id;
    public string $database_id;
    public string $created_at;
    /**
     * @var array<string> $links
     */
    public array $links;

    public function __construct(object $data)
    {
        $this->id = $data->id;
        $this->database_id = $data->database_id;
        $this->created_at = $data->created_at;
        $this->links = $data->_links;
    }
}
