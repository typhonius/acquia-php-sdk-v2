<?php

namespace AcquiaCloudApi\Response;

class AccountResponse
{
    /**
     * @var int $id
     */
    public $id;

    /**
     * @var string $uuid
     */
    public $uuid;

    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $first_name
     */
    public $first_name;

    /**
     * @var string $last_name
     */
    public $last_name;

    /**
     * @var string $last_login_at
     */
    public $last_login_at;

    /**
     * @var string $created_at
     */
    public $created_at;

    /**
     * @var string $mail
     */
    public $mail;

    /**
     * @var object $phone
     */
    public $phone;

    /**
     * @var string $job_title
     */
    public $job_title;

    /**
     * @var string $job_function
     */
    public $job_function;

    /**
     * @var string $company
     */
    public $company;

    /**
     * @var string $country
     */
    public $country;

    /**
     * @var string $state
     */
    public $state;

    /**
     * @var string $timezone
     */
    public $timezone;

    /**
     * @var string $picture_url
     */
    public $picture_url;

    /**
     * @var array<string> $features
     */
    public $features;

    /**
     * @var object $flags
     */
    public $flags;

    /**
     * @var object $metadata
     */
    public $metadata;

    /**
     * @var string $links
     */
    public $links;

    /**
     * @param object $account
     */
    public function __construct(object $account)
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
