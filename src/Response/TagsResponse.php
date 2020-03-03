<?php

namespace AcquiaCloudApi\Response;

/**
 * Class TagsResponse
 *
 * @package AcquiaCloudApi\Response
 */
class TagsResponse extends \ArrayObject
{

    /**
     * TagsResponse constructor.
     *
     * @param array $tags
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
