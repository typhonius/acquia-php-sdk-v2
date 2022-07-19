<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Applications;
use AcquiaCloudApi\Endpoints\LogForwardingDestinations;
use AcquiaCloudApi\Exception\NoLinkedResourceException;
use AcquiaCloudApi\Exception\LinkedResourceNotFoundException;
use AcquiaCloudApi\Exception\LinkedResourceNotImplementedException;

class LinkedResourcesTest extends CloudApiTestCase
{

    public function testGetLink(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Applications/getApplication.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $application = new Applications($client);
        $result = $application->get('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->assertInstanceOf('\AcquiaCloudApi\Response\ApplicationResponse', $result);

        $environments = $result->getLink('environments');
        $expectedEnvironments = [
            'type' => 'environments',
            'path' => '{baseUri}/applications/185f07c7-9c4f-407b-8968-67892ebcb38a/environments',
            'responseClass' => 'AcquiaCloudApi\Response\ApplicationResponse'
        ];
        $this->assertEquals($expectedEnvironments, $environments);

        $databases = $result->getLink('databases');
        $expectedDatabases = [
            'type' => 'databases',
            'path' => '{baseUri}/applications/185f07c7-9c4f-407b-8968-67892ebcb38a/databases',
            'responseClass' => 'AcquiaCloudApi\Response\ApplicationResponse'
        ];
        $this->assertEquals($expectedDatabases, $databases);
    }

    public function testGetLinkedEnvironments(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Environments/getAllEnvironments.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $application = new Applications($client);

        $environmentsLink = [
            'type' => 'environments',
            'path' => '{baseUri}/applications/185f07c7-9c4f-407b-8968-67892ebcb38a/environments',
            'responseClass' => 'AcquiaCloudApi\Response\ApplicationResponse'
        ];
        $environments = $client->getLinkedResource($environmentsLink);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\EnvironmentsResponse', $environments);
    }

    public function testGetLinkedDatabases(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Databases/getAllDatabases.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $application = new Applications($client);

        $databasesLink = [
            'type' => 'databases',
            'path' => '{baseUri}/applications/185f07c7-9c4f-407b-8968-67892ebcb38a/databases',
            'responseClass' => 'AcquiaCloudApi\Response\ApplicationResponse'
        ];
        $databases = $client->getLinkedResource($databasesLink);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\DatabasesResponse', $databases);
    }

    public function testGetLinkedCode(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Code/getAllCode.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $application = new Applications($client);

        $codeLink = [
            'type' => 'code',
            'path' => '{baseUri}/applications/185f07c7-9c4f-407b-8968-67892ebcb38a/code',
            'responseClass' => 'AcquiaCloudApi\Response\ApplicationResponse'
        ];
        $branches = $client->getLinkedResource($codeLink);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\BranchesResponse', $branches);
    }
    public function testGetLinkedInsights(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Insights/getAllInsights.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $application = new Applications($client);

        $insightsLink = [
            'type' => 'insight',
            'path' => '{baseUri}/applications/185f07c7-9c4f-407b-8968-67892ebcb38a/insight',
            'responseClass' => 'AcquiaCloudApi\Response\ApplicationResponse'
        ];
        $insights = $client->getLinkedResource($insightsLink);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\InsightsResponse', $insights);
    }

    public function testGetLinkedPermissions(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Permissions/getPermissions.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $application = new Applications($client);

        $permissionsLink = [
            'type' => 'permissions',
            'path' => '{baseUri}/applications/185f07c7-9c4f-407b-8968-67892ebcb38a/permissions',
            'responseClass' => 'AcquiaCloudApi\Response\ApplicationResponse'
        ];
        $permissions = $client->getLinkedResource($permissionsLink);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\PermissionsResponse', $permissions);
    }

    public function testGetLinkedTeams(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Teams/getAllTeams.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $application = new Applications($client);

        $teamsLink = [
            'type' => 'teams',
            'path' => '{baseUri}/applications/185f07c7-9c4f-407b-8968-67892ebcb38a/teams',
            'responseClass' => 'AcquiaCloudApi\Response\ApplicationResponse'
        ];
        $teams = $client->getLinkedResource($teamsLink);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\TeamsResponse', $teams);
    }

    public function testGetLinkNotImplementedError(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Applications/getApplication.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $application = new Applications($client);
        $application->get('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $selfLink = [
            'type' => 'parent',
            'path' => '{baseUri}/applications/185f07c7-9c4f-407b-8968-67892ebcb38a',
            'responseClass' => 'AcquiaCloudApi\Response\ApplicationResponse'
        ];

        $this->expectException(LinkedResourceNotImplementedException::class);
        $this->expectExceptionMessage('parent link not implemented in this SDK. Please file an issue here: https://github.com/typhonius/acquia-php-sdk-v2/issues');

        $client->getLinkedResource($selfLink);
    }

    public function testHrefNotFoundError(): void
    {
        // Test links that have no href keys.
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Error/applicationWithoutHrefLinks.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $application = new Applications($client);

        $result = $application->get('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->expectException(LinkedResourceNotFoundException::class);
        $this->expectExceptionMessage('No href property exists for databases');

        $link = $result->getLink('databases');
    }

    public function testLinkedResourcesNotFoundError(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Applications/getApplication.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $application = new Applications($client);

        $result = $application->get('8ff6c046-ec64-4ce4-bea6-27845ec18600');

        $this->expectException(LinkedResourceNotFoundException::class);
        $this->expectExceptionMessage('No property exists for potatoes. Available links are self code databases environments events features insight permissions settings tasks teams parent');

        $result->getLink('potatoes');
    }

    public function testNoLinkedResourcesError(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/LogForwarding/getLogForwarding.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\Connector\ClientInterface $client */
        $logForwarding = new LogForwardingDestinations($client);
        $result = $logForwarding->get('8ff6c046-ec64-4ce4-bea6-27845ec18600', 3);

        $this->assertInstanceOf('\AcquiaCloudApi\Response\LogForwardingDestinationResponse', $result);

        $this->expectException(NoLinkedResourceException::class);
        $this->expectExceptionMessage('No linked resources for AcquiaCloudApi\Response\LogForwardingDestinationResponse');

        $result->getLink('bananas');
    }
}
