<?php

namespace AcquiaCloudApi\Response;

use AcquiaCloudApi\Traits\LinkedResourceTrait;

/**
 * @template TValue
 * @template-extends \ArrayObject<int,TValue>
 */
abstract class CollectionResponse extends \ArrayObject
{
    use LinkedResourceTrait;

    /**
     * @var object $links
     */
    public $links;

    /**
     * @param string $class
     * @param object|array<int, object> $body
     */
    public function __construct(string $class, $body)
    {
        // Links will not be available if we create a CollectionResponse manually within
        // a GenericResponse e.g. a TeamsResponse as part of a MemberResponse.
        if (is_object($body)) {
            $this->links = $body->_links;

            if (!property_exists($body, '_embedded') || !property_exists($body->_embedded, 'items')) {
                throw new \Exception('CollectionResponse does not contain embedded items.');
            }
            $items = $body->_embedded->items;
        } else {
            $items = $body;
        }

        $class = '\AcquiaCloudApi\Response\\' . $class;

        parent::__construct(
            array_map(
                static function ($child) use ($class) {
                    return new $class($child);
                },
                $items
            ),
            self::ARRAY_AS_PROPS
        );
    }
}
