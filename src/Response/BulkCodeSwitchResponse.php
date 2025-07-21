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

    /**
     * Get the bulk code switch ID.
     */
    public function getId(): ?string
    {
        $first = $this[0] ?? null;
        return $first?->id ?? null;
    }

    /**
     * Get the codebase ID.
     */
    public function getCodebaseId(): ?string
    {
        $first = $this[0] ?? null;
        return $first?->codebase_id ?? null;
    }

    /**
     * Get the reference.
     */
    public function getReference(): ?string
    {
        $first = $this[0] ?? null;
        return $first?->reference ?? null;
    }

    /**
     * Get the status.
     */
    public function getStatus(): ?string
    {
        $first = $this[0] ?? null;
        return $first?->status ?? null;
    }

    /**
     * Get the created timestamp.
     */
    public function getCreatedAt(): ?string
    {
        $first = $this[0] ?? null;
        return $first?->created_at ?? null;
    }

    /**
     * Get the message.
     */
    public function getMessage(): ?string
    {
        $first = $this[0] ?? null;
        return $first?->message ?? null;
    }
}
