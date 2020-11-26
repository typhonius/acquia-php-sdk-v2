<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<TagResponse>
 */
class TagsResponse extends CollectionResponse
{

    /**
     * @param array<object> $tags
     */
    public function __construct($tags)
    {
        parent::__construct('TagResponse', $tags);
    }
}
