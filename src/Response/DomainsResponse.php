<?php

namespace AcquiaCloudApi\Response;

/**
 * @template TValue
 * @template-extends \ArrayObject<int,TValue>
 */
class DomainsResponse extends \ArrayObject
{

    /**
     * @param array<object> $domains
     */
    public function __construct($domains)
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
