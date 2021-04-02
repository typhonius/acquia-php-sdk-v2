<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<SshKeyResponse>
 */
class SshKeysResponse extends CollectionResponse
{

    /**
     * @param array<object> $sshkeys
     */
    public function __construct($sshkeys)
    {
        parent::__construct('SshKeyResponse', $sshkeys);
    }
}
