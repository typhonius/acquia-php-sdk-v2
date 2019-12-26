<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\IdentityProviders;

class IdentityProviderTest extends CloudApiTestCase
{

    public $properties = [
    'uuid',
    'label',
    'idp_entity_id',
    'sso_url',
    'certificate',
    'status',
    'links',
    ];

    public function testGetLogForwardingDestinations()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/IdentityProviders/getAllIdentityProviders.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $idp = new IdentityProviders($client);
        $result = $idp->getAll();

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\IdentityProvidersResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\IdentityProviderResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetLogForwardingDestination()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/IdentityProviders/getIdentityProvider.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $idp = new IdentityProviders($client);
        $result = $idp->get('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\IdentityProvidersResponse', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\IdentityProviderResponse', $result);

        foreach ($this->properties as $property) {
              $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testDeleteLogForwardingDestination()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/IdentityProviders/deleteIdentityProvider.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $idp = new IdentityProviders($client);
        $result = $idp->delete('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Identity provider has been deleted.', $result->message);
    }

    public function testEnableLogForwardingDestination()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/IdentityProviders/enableIdentityProvider.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $idp = new IdentityProviders($client);
        $result = $idp->enable('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Identity Provider has been enabled.', $result->message);
    }

    public function testDisableLogForwardingDestination()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/IdentityProviders/disableIdentityProvider.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $idp = new IdentityProviders($client);
        $result = $idp->disable('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Identity Provider has been disabled.', $result->message);
    }

    public function testUpdateLogForwardingDestination()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/IdentityProviders/updateIdentityProvider.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $idp = new IdentityProviders($client);
        $result = $idp->update(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            'Test IDP',
            'entity-id',
            'https://idp.example.com',
            "-----BEGIN CERTIFICATE-----...-----END CERTIFICATE-----"
        );

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Identity Provider has been updated.', $result->message);
    }
}
