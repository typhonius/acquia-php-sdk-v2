<?php

namespace AcquiaCloudApi\Endpoints;

use AcquiaCloudApi\Connector\ClientInterface;
use AcquiaCloudApi\Response\InsightsResponse;
use AcquiaCloudApi\Response\InsightResponse;
use AcquiaCloudApi\Response\OperationResponse;

/**
 * Class Client
 * @package AcquiaCloudApi\CloudApi
 */
class Insights implements CloudApi
{

    /** @var ClientInterface The API client. */
    protected $client;

    /**
     * Client constructor.
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Returns Insight data for all sites associated with the application by its UUID.
     *
     * @param string $applicationUuid
     * @return InsightsResponse
     */
    public function getAll($applicationUuid)
    {
        return new InsightsResponse(
            $this->client->request(
                'get',
                "/applications/${applicationUuid}/insight"
            )
        );
    }

    /**
     * Returns insight data for a particular site.
     *
     * @param string $siteId
     * @return InsightResponse
     */
    public function get($siteId)
    {
        return new InsightResponse(
            $this->client->request(
                'get',
                "/insight/${siteId}"
            )
        );
    }
}
