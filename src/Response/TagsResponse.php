<?php

namespace AcquiaCloudApi\Response;

/**
 * @template TValue
 * @template-extends \ArrayObject<int,TValue>
 */
class TagsResponse extends \ArrayObject
{

    /**
     * @param array<object> $tags
     */
    public function __construct($tags)
    {
        parent::__construct(
            array_map(
                function ($tag) {
                    return new TagResponse($tag);
                },
                $tags
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
