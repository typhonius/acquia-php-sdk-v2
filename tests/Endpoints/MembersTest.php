<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Organizations;
use AcquiaCloudApi\Response\MemberResponse;
use AcquiaCloudApi\Response\MembersResponse;

class MembersTest extends CloudApiTestCase
{
    public function testGetOrganizationMembers(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Organizations/getMembers.json');
        $client = $this->getMockClient($response);

        $organization = new Organizations($client);
        $result = $organization->getMembers('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(MemberResponse::class, $record);
        }
    }

    public function testGetOrganizationMember(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Organizations/getMember.json');
        $client = $this->getMockClient($response);

        $organization = new Organizations($client);
        $result = $organization->getMember(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            'f2daa9cc-e5a0-4036-a5c8-f96e336c62b5'
        );

        $this->assertNotInstanceOf(MembersResponse::class, $result);
    }

    public function testGetOrganizationAdmins(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Organizations/getAdmins.json');
        $client = $this->getMockClient($response);

        $organization = new Organizations($client);
        $result = $organization->getAdmins('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(MemberResponse::class, $record);
        }
    }

    public function testGetOrganizationAdmin(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Organizations/getAdmin.json');
        $client = $this->getMockClient($response);

        $organization = new Organizations($client);
        $result = $organization->getAdmin(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            'f2daa9cc-e5a0-4036-a5c8-f96e336c62b5'
        );

        $this->assertNotInstanceOf(MembersResponse::class, $result);
    }

    public function testMemberDelete(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Organizations/deleteMember.json');
        $client = $this->getMockClient($response);

        $organization = new Organizations($client);
        $result = $organization->deleteMember(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851'
        );

        $this->assertEquals("Organization member removed.", $result->message);
    }
}
