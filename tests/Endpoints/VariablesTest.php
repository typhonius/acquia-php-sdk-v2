<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Endpoints\Variables;
use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Response\VariableResponse;

class VariablesTest extends CloudApiTestCase
{
    public function testGetVariables(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Variables/getAllVariables.json');
        $client = $this->getMockClient($response);

        $variable = new Variables($client);
        $result = $variable->getAll('24-569086da-2b1f-11e9-b210-d663bd873d93');

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(VariableResponse::class, $record);
        }
    }

    public function testGetVariable(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Variables/getVariable.json');
        $client = $this->getMockClient($response);

        $variable = new Variables($client);
        $result = $variable->get('24-734b7960-2b1f-11e9-b210-d663bd873d93', 'variable_one');

        $this->assertEquals('variable_one', $result->name);
        $this->assertEquals('Sample Value One', $result->value);
    }

    public function testVariableAdd(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Variables/createVariable.json');
        $client = $this->getMockClient($response);

        $variable = new Variables($client);
        $result = $variable->create('123-c7056b9e-0fb7-44e9-a434-426a404211c1', 'test_variable', 'test_value');

        $requestOptions = [
            'json' => [
                'name' => 'test_variable',
                'value' => 'test_value',
            ],
        ];
        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals("The environment variable is being added.", $result->message);
    }

    public function testUpdateVariable(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Variables/updateVariable.json');
        $client = $this->getMockClient($response);

        $variable = new Variables($client);
        $result = $variable->update(
            '24-734b7960-2b1f-11e9-b210-d663bd873d93',
            'name',
            'value'
        );

        $requestOptions = [
            'json' => [
                'name' => 'name',
                'value' => 'value',
            ],
        ];
        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals('The environment variable is being updated.', $result->message);
    }

    public function testVariableDelete(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Variables/deleteVariable.json');
        $client = $this->getMockClient($response);

        $variable = new Variables($client);
        $result = $variable->delete('12-d314739e-296f-11e9-b210-d663bd873d93', 'EXAMPLE_VARIABLE_NAME');

        $this->assertEquals("The environment variable is being removed.", $result->message);
    }
}
