<?php

class FiltersTest extends CloudApiTestCase
{

    public function testAddFilter()
    {

      /** @var \AcquiaCloudApi\CloudApi\ClientInterface $object */
        $object = $this->getMockClient();

        $expectedValue = ['filter' => 'name=@"foobar"'];
        $object->addQuery('filter', 'name=@"foobar"');
        $property = $this->getPrivateProperty(get_class($object), 'query');
        $this->assertEquals($property->getValue($object), $expectedValue);

        $expectedValue = ['filter' => ['name=@"foobar"', 'type=@"baz"']];
        $object->addQuery('filter', 'type=@"baz"');
        $property = $this->getPrivateProperty(get_class($object), 'query');
        $this->assertEquals($property->getValue($object), $expectedValue);

        $expectedValue = ['sort' => 'title', 'filter' => ['name=@"foobar"', 'type=@"baz"']];
        $object->addQuery('sort', 'title');
        $property = $this->getPrivateProperty(get_class($object), 'query');
        $this->assertEquals($property->getValue($object), $expectedValue);

        $timezone = new \DateTimeZone('UTC');
        $time = new \DateTime(date('c'));
        $time->setTimezone($timezone);
        $datetime = $time->format(\DateTime::ATOM);

        $expectedValue = [
            'from' => $datetime,
            'to' => $datetime,
            'sort' => 'title',
            'filter' => ['name=@"foobar"', 'type=@"baz"']
        ];
        $object->addQuery('from', $datetime);
        $object->addQuery('to', $datetime);
        $property = $this->getPrivateProperty(get_class($object), 'query');
        $this->assertEquals($property->getValue($object), $expectedValue);

        $expectedValue = [
            'limit' => 5,
            'offset' => 1,
            'from' => $datetime,
            'to' => $datetime,
            'sort' => 'title',
            'filter' => ['name=@"foobar"', 'type=@"baz"']
        ];
        $object->addQuery('limit', 5);
        $object->addQuery('offset', 1);
        $property = $this->getPrivateProperty(get_class($object), 'query');
        $this->assertEquals($property->getValue($object), $expectedValue);

        $expectedValue = [];
        $object->clearQuery();
        $property = $this->getPrivateProperty(get_class($object), 'query');
        $this->assertEquals($property->getValue($object), $expectedValue);
    }

    public function getPrivateProperty($className, $propertyName)
    {
        $reflector = new ReflectionClass($className);
        $property = $reflector->getProperty($propertyName);
        $property->setAccessible(true);

        return $property;
    }
}
