<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\BackupResponse>
 */
class BackupsResponse extends \ArrayObject
{

    /**
     * @param array<object> $backups
     */
    public function __construct($backups)
    {
        parent::__construct(
            array_map(
                function ($backup) {
                    return new BackupResponse($backup);
                },
                $backups
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
