<?php

namespace AcquiaCloudApi\Response;

/**
 * Class BackupsResponse
 * @package AcquiaCloudApi\Response
 */
class BackupsResponse extends \ArrayObject
{

    /**
     * BackupsResponse constructor.
     * @param array $backups
     */
    public function __construct($backups)
    {
        parent::__construct(array_map(function ($backup) {
            return new BackupResponse($backup);
        }, $backups), self::ARRAY_AS_PROPS);
    }
}
