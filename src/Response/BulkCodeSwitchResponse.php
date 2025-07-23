<?php

namespace AcquiaCloudApi\Response;

use ArrayObject;

/**
 * @template-extends \ArrayObject<int, object>
 */
class BulkCodeSwitchResponse extends ArrayObject
{
    /**
     * @param array<object>|object $bulkCodeSwitch
     */
    public function __construct(array|object $bulkCodeSwitch)
    {
        if (is_array($bulkCodeSwitch)) {
            // Handle array of bulk code switches
            parent::__construct(
                array_map(
                    static function ($item) {
                        return (object) $item;
                    },
                    $bulkCodeSwitch
                ),
                self::ARRAY_AS_PROPS
            );
        } else {
            // Handle single bulk code switch object
            parent::__construct(
                [$bulkCodeSwitch],
                self::ARRAY_AS_PROPS
            );
        }
    }

}
