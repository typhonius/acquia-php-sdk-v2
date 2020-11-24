<?php

namespace AcquiaCloudApi\Response;

/**
 * @template TValue
 * @template-extends \ArrayObject<int,TValue>
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
