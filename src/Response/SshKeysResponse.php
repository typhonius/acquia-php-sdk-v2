<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\SshKeyResponse>
 */
class SshKeysResponse extends \ArrayObject
{
    /**
     * @param array<object> $sshkeys
     */
    public function __construct($sshkeys)
    {
        parent::__construct(
            array_map(
                function ($sshkey) {
                    return new SshKeyResponse($sshkey);
                },
                $sshkeys
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
