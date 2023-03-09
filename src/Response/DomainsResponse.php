<?php

namespace AcquiaCloudApi\Response;

/**
 * @template-extends \ArrayObject<int, \AcquiaCloudApi\Response\DomainResponse>
 */
class DomainsResponse extends \ArrayObject
{
    /**
     * @param array<object> $domains
     */
    public function __construct(array $domains)
    {
        parent::__construct(
            array_map(
                function ($domain) {
                    return new DomainResponse($domain);
                },
                $domains
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
