<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Endpoints\Variables;
use AcquiaCloudApi\Tests\CloudApiTestCase;

class VariablesTest extends CloudApiTestCase
{

    public $properties = [
        'name',
        'value',
        'links',
    ];

    public function testGetVariables()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Variables/getAllVariables.json');
        $client = $this->getMockClient($response);

        $variable = new Variables($client);
        $result = $variable->getAll('24-569086da-2b1f-11e9-b210-d663bd873d93');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\VariablesResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\VariableResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetVariable()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Variables/getVariable.json');
        $client = $this->getMockClient($response);

        $variable = new Variables($client);
        $result = $variable->get('24-734b7960-2b1f-11e9-b210-d663bd873d93', 'variable_one');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\VariableResponse', $result);
        $this->assertEquals('variable_one', $result->name);
        $this->assertEquals('Sample Value One', $result->value);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testVariableAdd()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Variables/createVariable.json');
        $client = $this->getMockClient($response);

        $variable = new Variables($client);
        $result = $variable->create('123-c7056b9e-0fb7-44e9-a434-426a404211c1', 'test_variable', 'test_value');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals("The environment variable is being added.", $result->message);
    }

    public function testUpdateVariable()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Variables/updateVariable.json');
        $client = $this->getMockClient($response);

        $variable = new Variables($client);
        $result = $variable->update(
            '24-734b7960-2b1f-11e9-b210-d663bd873d93',
            'name',
            'value'
        );

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('The environment variable is being updated.', $result->message);
    }

    public function testVariableDelete()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Variables/deleteVariable.json');
        $client = $this->getMockClient($response);

        $variable = new Variables($client);
        $result = $variable->delete('12-d314739e-296f-11e9-b210-d663bd873d93', 'EXAMPLE_VARIABLE_NAME');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);
        $this->assertEquals("The environment variable is being removed.", $result->message);
    }
}
