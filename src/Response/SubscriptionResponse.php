<?php

namespace AcquiaCloudApi\Response;

class SubscriptionResponse
{
    public int $id;

    public string $uuid;

    public string $name;

    public string $start_at;

    public string $expire_at;

    public object $product;

    public int $applications_total;

    public int $applications_used;

    public object $organization;

    public object $flags;

    public object $links;

    public function __construct(object $subscription)
    {
        $this->id = $subscription->id;
        $this->uuid = $subscription->uuid;
        $this->name = $subscription->name;
        $this->start_at = $subscription->start_at;
        $this->expire_at = $subscription->expire_at;
        $this->product = $subscription->product;
        $this->applications_total = $subscription->applications_total;
        $this->applications_used = $subscription->applications_used;
        $this->organization = $subscription->organization;
        $this->flags = $subscription->flags;
        $this->links = $subscription->_links;
    }
}
