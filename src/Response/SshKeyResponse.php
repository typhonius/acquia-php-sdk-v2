<?php

namespace AcquiaCloudApi\Response;

/**
 * Class SshKeyResponse
 *
 * @package AcquiaCloudApi\Response
 */
class SshKeyResponse extends GenericResponse
{
    /**
     * @var string $uuid
     */
    public $uuid;

    /**
     * @var string $label
     */
    public $label;

    /**
     * @var string $public_key
     */
    public $public_key;

    /**
     * @var string $fingerprint
     */
    public $fingerprint;

    /**
     * @var string $created_at
     */
    public $created_at;

    /**
     * @var object $links
     */
    public $links;

    /**
     * SshKeyResponse constructor.
     *
     * @param object $sshkey
     */

    public function __construct($sshkey)
    {
        $this->uuid = $sshkey->uuid;
        $this->label = $sshkey->label;
        $this->public_key = $sshkey->public_key;
        $this->fingerprint = $sshkey->fingerprint;
        $this->created_at = $sshkey->created_at;
        $this->links = $sshkey->_links;
    }
}
