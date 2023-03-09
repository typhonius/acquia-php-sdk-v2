<?php

namespace AcquiaCloudApi\Response;

/**
 * Class SshKeyResponse
 *
 * @package AcquiaCloudApi\Response
 */
class SshKeyResponse
{
    public string $uuid;

    public string $label;

    public string $public_key;

    public string $fingerprint;

    public string $created_at;

    public object $links;

    /**
     * SshKeyResponse constructor.
     *
     */

    public function __construct(object $sshkey)
    {
        $this->uuid = $sshkey->uuid;
        $this->label = $sshkey->label;
        $this->public_key = $sshkey->public_key;
        $this->fingerprint = $sshkey->fingerprint;
        $this->created_at = $sshkey->created_at;
        $this->links = $sshkey->_links;
    }
}
