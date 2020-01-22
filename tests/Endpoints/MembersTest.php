<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\Organizations;

class MembersTest extends CloudApiTestCase
{

    public $properties = [
        'uuid',
        'teams',
        'first_name',
        'last_name',
        'mail',
        'picture_url',
        'username',
        'links'
    ];

    public function testGetOrganizationMembers()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Organizations/getMembers.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $organization = new Organizations($client);
        $result = $organization->getMembers('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\MembersResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\MemberResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetOrganizationMember()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Organizations/getMember.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $organization = new Organizations($client);
        $result = $organization->getMember(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            'f2daa9cc-e5a0-4036-a5c8-f96e336c62b5'
        );

        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\MembersResponse', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\MemberResponse', $result);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testGetOrganizationAdmins()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Organizations/getAdmins.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $organization = new Organizations($client);
        $result = $organization->getAdmins('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\MembersResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\MemberResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetOrganizationAdmin()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Organizations/getAdmin.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $organization = new Organizations($client);
        $result = $organization->getAdmin(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            'f2daa9cc-e5a0-4036-a5c8-f96e336c62b5'
        );

        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\MembersResponse', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\MemberResponse', $result);

        foreach ($this->properties as $property) {
            $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testMemberDelete()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Organizations/deleteMember.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $organization = new Organizations($client);
        $result = $organization->deleteMember(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851'
        );

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals("Organization member removed.", $result->message);
    }
}
