<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\IdentityProviders;
use AcquiaCloudApi\Response\IdentityProvidersResponse;
use AcquiaCloudApi\Response\IdentityProviderResponse;

class IdentityProviderTest extends CloudApiTestCase
{
    public function testGetLogForwardingDestinations(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/IdentityProviders/getAllIdentityProviders.json');
        $client = $this->getMockClient($response);

        $idp = new IdentityProviders($client);
        $result = $idp->getAll();

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(IdentityProviderResponse::class, $record);
        }
    }

    public function testGetLogForwardingDestination(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/IdentityProviders/getIdentityProvider.json');
        $client = $this->getMockClient($response);

        $idp = new IdentityProviders($client);
        $result = $idp->get('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertNotInstanceOf(IdentityProvidersResponse::class, $result);
    }

    public function testDeleteLogForwardingDestination(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/IdentityProviders/deleteIdentityProvider.json');
        $client = $this->getMockClient($response);

        $idp = new IdentityProviders($client);
        $result = $idp->delete('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertEquals('Identity provider has been deleted.', $result->message);
    }

    public function testEnableLogForwardingDestination(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/IdentityProviders/enableIdentityProvider.json');
        $client = $this->getMockClient($response);

        $idp = new IdentityProviders($client);
        $result = $idp->enable('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertEquals('Identity Provider has been enabled.', $result->message);
    }

    public function testDisableLogForwardingDestination(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/IdentityProviders/disableIdentityProvider.json');
        $client = $this->getMockClient($response);

        $idp = new IdentityProviders($client);
        $result = $idp->disable('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertEquals('Identity Provider has been disabled.', $result->message);
    }

    public function testUpdateLogForwardingDestination(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/IdentityProviders/updateIdentityProvider.json');
        $client = $this->getMockClient($response);

        $idp = new IdentityProviders($client);
        $result = $idp->update(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            'Test IDP',
            'entity-id',
            'https://idp.example.com',
            "-----BEGIN CERTIFICATE-----...-----END CERTIFICATE-----"
        );

        $requestOptions = [
            'json' => [
                'label' => 'Test IDP',
                'entity_id' => 'entity-id',
                'sso_url' => 'https://idp.example.com',
                'certificate' => "-----BEGIN CERTIFICATE-----...-----END CERTIFICATE-----",
            ],
        ];

        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals('Identity Provider has been updated.', $result->message);
    }
}
