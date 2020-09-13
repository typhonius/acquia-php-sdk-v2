<?php

namespace AcquiaCloudApi\Response;

/**
 * Class AccountResponse
 *
 * @package AcquiaCloudApi\Response
 */
class AccountResponse
{

    public $id;
    public $uuid;
    public $name;
    public $first_name;
    public $last_name;
    public $last_login_at;
    public $created_at;
    public $mail;
    public $phone;
    public $job_title;
    public $job_function;
    public $company;
    public $country;
    public $state;
    public $timezone;
    public $picture_url;
    public $features;
    public $flags;
    public $metadata;
    public $links;

    /**
     * AccountResponse constructor.
     *
     * @param object $account
     */
    public function __construct($account)
    {
        $this->id = $account->id;
        $this->uuid = $account->uuid;
        $this->name = $account->name;
        $this->first_name = $account->first_name;
        $this->last_name = $account->last_name;
        $this->last_login_at = $account->last_login_at;
        $this->created_at = $account->created_at;
        $this->mail = $account->mail;
        $this->phone = $account->phone;
        $this->job_title = $account->job_title;
        $this->job_function = $account->job_function;
        $this->company = $account->company;
        $this->country = $account->country;
        $this->state = $account->state;
        $this->timezone = $account->timezone;
        $this->picture_url = $account->picture_url;
        $this->features = $account->features;
        $this->flags = $account->flags;
        $this->metadata = $account->metadata;
        $this->links = $account->_links;
    }
}
