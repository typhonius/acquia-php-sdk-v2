<?php

namespace AcquiaCloudApi\Response;

/**
 * Class SiteInstanceResponse
 *
 * @package AcquiaCloudApi\Response
 */
class SiteInstanceResponse
{
    /**
     * The site ID string
     */
    public string $site_id;

    /**
     * The environment ID string
     */
    public string $environment_id;

    /**
     * The status of the site instance
     *
     * One of: "SITE_INSTANCE_STATUS_UNSPECIFIED", "SITE_INSTANCE_STATUS_PENDING",
     * "SITE_INSTANCE_STATUS_READY", "SITE_INSTANCE_STATUS_FAILED",
     * "SITE_INSTANCE_STATUS_MARKED_FOR_DELETION", "SITE_INSTANCE_STATUS_DELETING",
     * "SITE_INSTANCE_STATUS_DELETED", "SITE_INSTANCE_STATUS_DELETE_FAILED",
     * "SITE_INSTANCE_STATUS_SYNCING", "SITE_INSTANCE_STATUS_FINALIZING",
     * "SITE_INSTANCE_STATUS_DISABLED"
     */
    public string $status;

    /**
     * The health status of the site instance
     *
     * Object with code, summary and details properties
     */
    public ?object $health_status;

    /**
     * The domains associated with this site instance
     *
     * @var array<object> Array of domain objects with name and is_managed properties
     */
    public ?array $domains;

    /**
     * The site object containing site information
     */
    public ?SiteResponse $site = null;

    /**
     * The environment object containing environment information
     */
    public ?CodebaseEnvironmentResponse $environment = null;


    /**
     * The links object containing related URLs
     */
    public object $links;

    /**
     * SiteInstanceResponse constructor.
     */
    public function __construct(object $siteInstance)
    {
        $this->site_id = $siteInstance->site_id;
        $this->environment_id = $siteInstance->environment_id;
        $this->status = $siteInstance->status;

        // Make sure health_status is always an object, whether it's null, missing, or an array
        $health_status = $siteInstance->health_status ?? [];
        $this->health_status = is_object($health_status) ? $health_status : (object) $health_status;

        $this->domains = $siteInstance->domains ?? [];
        // Make sure $links is always an object, whether it's null, missing, or an array
        $links = $siteInstance->_links ?? [];
        $this->links = is_object($links) ? $links : (object) $links;

        // Handle legacy properties for backward compatibility
        if (property_exists($siteInstance, 'site')) {
            $this->site = new SiteResponse($siteInstance->site);
        }

        if (property_exists($siteInstance, 'environment')) {
            $this->environment = new CodebaseEnvironmentResponse($siteInstance->environment);
        }
    }
}
