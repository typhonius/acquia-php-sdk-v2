<?php

namespace AcquiaCloudApi\Response;

use ArrayObject;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\SiteInstanceDatabaseBackupResponse>
 */
class SiteInstanceDatabaseBackupsResponse extends ArrayObject
{
    /**
     * @param array<object> $backups
     */
    public function __construct(array $backups)
    {
        parent::__construct(
            array_map(
                static function ($backup) {
                    return new SiteInstanceDatabaseBackupResponse($backup);
                },
                $backups
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
