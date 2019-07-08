<?php

namespace AcquiaCloudApi\Response;

/**
 * Class AccountResponse
 * @package AcquiaCloudApi\Response
 */
class AccountResponse
{

    public $id;
    public $uuid;
    public $name;
    public $last_login_at;
    public $created_at;
    public $mail;
    public $features;
    public $flags;
    public $metadata;
    public $links;

    /**
     * AccountResponse constructor.
     * @param object $account
     */
    public function __construct($account)
    {
        $this->id = $account->id;
        $this->uuid = $account->uuid;
        $this->name = $account->name;
        $this->last_login_at = $account->last_login_at;
        $this->created_at = $account->created_at;
        $this->mail = $account->mail;
        $this->features = $account->features;
        $this->flags = $account->flags;
        $this->metadata = $account->metadata;
        $this->links = $account->_links;
    }
}
