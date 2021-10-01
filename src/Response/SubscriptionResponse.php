<?php

namespace AcquiaCloudApi\Response;

class SubscriptionResponse
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
     * @var string $start_at
     */
    public $start_at;

    /**
     * @var string $expire_at
     */
    public $expire_at;

    /**
     * @var object $product
     */
    public $product;

    /**
     * @var int $applications_total
     */
    public $applications_total;

    /**
     * @var int $applications_used
     */
    public $applications_used;

    /**
     * @var int $advisory_hours_total
     */
    public $advisory_hours_total;

    /**
     * @var int $advisory_hours_used
     */
    public $advisory_hours_used;

    /**
     * @var object $organization
     */
    public $organization;

    /**
     * @var object $flags
     */
    public $flags;

    /**
     * @var object $links
     */
    public $links;

    /**
     * @param object $subscription
     */
    public function __construct($subscription)
    {
        $this->id = $subscription->id;
        $this->uuid = $subscription->uuid;
        $this->name = $subscription->name;
        $this->start_at = $subscription->start_at;
        $this->expire_at = $subscription->expire_at;
        $this->product = $subscription->product;
        $this->applications_total = $subscription->applications_total;
        $this->applications_used = $subscription->applications_used;
        $this->advisory_hours_total = $subscription->advisory_hours_total;
        $this->advisory_hours_used = $subscription->advisory_hours_used;
        $this->organization = $subscription->organization;
        $this->flags = $subscription->flags;
        $this->links = $subscription->_links;
    }
}
