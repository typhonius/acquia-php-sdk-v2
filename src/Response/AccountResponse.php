<?php

namespace AcquiaCloudApi\Response;

class AccountResponse
{
    public int $id;

    public string $uuid;

    public string $name;

    public string $first_name;

    public string $last_name;

    // public string $last_login_at;

    public string $created_at;

    public string $mail;

    public object $phone;

    public ?string $job_title;

    public ?string $job_function;

    public ?string $company;

    public ?string $country;

    public ?string $state;

    public string $timezone;

    public string $picture_url;

    /**
     * @var array<string> $features
     */
    public array $features;

    public object $flags;

    public object $metadata;

    public object $links;

    public function __construct(object $account)
    {
        $this->id = $account->id;
        $this->uuid = $account->uuid;
        $this->name = $account->name;
        $this->first_name = $account->first_name;
        $this->last_name = $account->last_name;
        // $this->last_login_at = $account->last_login_at;
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
