<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Response\SiteResponse;
use AcquiaCloudApi\Response\SitesResponse;
use AcquiaCloudApi\Response\CodebaseEnvironmentsResponse;
use AcquiaCloudApi\Response\OperationResponse;
use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Sites;

class SitesTest extends CloudApiTestCase
{
    public function testGetAll(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Sites/getAllSites.json');
        $client = $this->getMockClient($response);

        $sites = new Sites($client);
        $result = $sites->getAll();

        $this->assertInstanceOf(SitesResponse::class, $result);
        $this->assertNotEmpty($result);
    }

    public function testGet(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Sites/getSite.json');
        $client = $this->getMockClient($response);

        $sites = new Sites($client);
        $result = $sites->get('8979a8ac-80dc-4df8-b2f0-6be36554a370');

        $this->assertInstanceOf(SiteResponse::class, $result);
        $this->assertEquals('8979a8ac-80dc-4df8-b2f0-6be36554a370', $result->id);
        $this->assertEquals('site1', $result->name);
        $this->assertEquals('My Site 1', $result->label);
        $this->assertEquals('My Site 1 description', $result->description);
        $this->assertEquals('1234-5678', $result->codebaseId);
    }

    public function testCreate(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Sites/createSite.json');
        $client = $this->getMockClient($response);

        $sites = new Sites($client);
        $result = $sites->create('new-site', 'New Site', '1234-5678', 'Test site description');

        $requestOptions = [
            'json' => [
                'name' => 'new-site',
                'label' => 'New Site',
                'codebase_id' => '1234-5678',
                'description' => 'Test site description',
            ],
        ];

        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertInstanceOf(OperationResponse::class, $result);
        $this->assertEquals('Site created successfully.', $result->message);
    }

    public function testUpdate(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Sites/updateSite.json');
        $client = $this->getMockClient($response);

        $sites = new Sites($client);
        $result = $sites->update(
            '8979a8ac-80dc-4df8-b2f0-6be36554a370',
            'updated-site',
            'Updated Site',
            'Updated description'
        );

        $requestOptions = [
            'json' => [
                'name' => 'updated-site',
                'label' => 'Updated Site',
                'description' => 'Updated description',
            ],
        ];

        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertInstanceOf(OperationResponse::class, $result);
        $this->assertEquals('Site updated successfully.', $result->message);
    }

    public function testDelete(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Sites/deleteSite.json');
        $client = $this->getMockClient($response);

        $sites = new Sites($client);
        $result = $sites->delete('8979a8ac-80dc-4df8-b2f0-6be36554a370');

        $this->assertInstanceOf(OperationResponse::class, $result);
        $this->assertEquals('Site deleted successfully.', $result->message);
    }

    public function testGetByEnvironment(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Sites/getAllSites.json');
        $client = $this->getMockClient($response);

        $sites = new Sites($client);
        $result = $sites->getByEnvironment('12-d314739e-296f-11e9-b210-d663bd873d93');

        $this->assertInstanceOf(SitesResponse::class, $result);
        $this->assertNotEmpty($result);
    }

    public function testGetByOrganization(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Sites/getAllSites.json');
        $client = $this->getMockClient($response);

        $sites = new Sites($client);
        $result = $sites->getByOrganization('1e7efab9-0fac-4a2c-ad94-61efc78623ba');

        $this->assertInstanceOf(SitesResponse::class, $result);
        $this->assertNotEmpty($result);
    }

    public function testGetByTeam(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Sites/getAllSites.json');
        $client = $this->getMockClient($response);

        $sites = new Sites($client);
        $result = $sites->getByTeam('3eef5d81-62f4-429c-aa94-e17d05ab4740');

        $this->assertInstanceOf(SitesResponse::class, $result);
        $this->assertNotEmpty($result);
    }

    public function testGetEnvironments(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Sites/getSiteEnvironments.json');
        $client = $this->getMockClient($response);

        $sites = new Sites($client);
        $result = $sites->getEnvironments('8979a8ac-80dc-4df8-b2f0-6be36554a370');

        $this->assertInstanceOf(CodebaseEnvironmentsResponse::class, $result);
        $this->assertNotEmpty($result);
    }
}
