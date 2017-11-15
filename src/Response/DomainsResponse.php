<?php

namespace AcquiaCloudApi\Response;

/**
 * Class DomainsResponse
 * @package AcquiaCloudApi\Response
 */
class DomainsResponse extends \ArrayObject
{

    /**
     * DomainsResponse constructor.
     * @param array $domains
     */
    public function __construct($domains)
    {
        parent::__construct(array_map(function ($domain) {
            return new DomainResponse($domain);
        }, $domains), self::ARRAY_AS_PROPS);
    }
}
