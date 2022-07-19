<?php

namespace AcquiaCloudApi\Exception;

use Exception;

/**
 * Thrown when a Response has linked resources but the name requested does not exist.
 */
class LinkedResourceNotFoundException extends Exception
{
}
