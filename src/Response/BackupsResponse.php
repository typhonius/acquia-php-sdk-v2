<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<BackupResponse>
 */
class BackupsResponse extends CollectionResponse
{

    /**
     * @param array<object> $backups
     */
    public function __construct($backups)
    {
        parent::__construct('BackupResponse', $backups);
    }
}
