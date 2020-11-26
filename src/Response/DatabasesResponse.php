<?php

namespace AcquiaCloudApi\Response;

/**
 * @extends CollectionResponse<DatabaseResponse>
 */
class DatabasesResponse extends CollectionResponse
{

    /**
     * @param array<object> $databases
     */
    public function __construct($databases)
    {
        parent::__construct('DatabaseResponse', $databases);
    }
}
