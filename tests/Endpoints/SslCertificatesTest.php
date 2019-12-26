<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\SslCertificates;

class SslCertificatesTest extends CloudApiTestCase
{

    public $properties = [
    'id',
    'label',
    'certificate',
    'private_key',
    'ca',
    'flags',
    'expires_at',
    'domains',
    'environment',
    'links'
    ];

    public function testGetCertificates()
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SslCertificates/getAllSslCertificates.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $certificate = new SslCertificates($client);
        $result = $certificate->getAll('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertInstanceOf('\ArrayObject', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\SslCertificatesResponse', $result);

        foreach ($result as $record) {
            $this->assertInstanceOf('\AcquiaCloudApi\Response\SslCertificateResponse', $record);

            foreach ($this->properties as $property) {
                $this->assertObjectHasAttribute($property, $record);
            }
        }
    }

    public function testGetCertificate()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SslCertificates/getSslCertificate.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $certificate = new SslCertificates($client);
        $result = $certificate->get('8ff6c046-ec64-4ce4-bea6-27845ec18600', 3);

        $this->assertNotInstanceOf('\AcquiaCloudApi\Response\SslCertificatesResponse', $result);
        $this->assertInstanceOf('\AcquiaCloudApi\Response\SslCertificateResponse', $result);

        foreach ($this->properties as $property) {
              $this->assertObjectHasAttribute($property, $result);
        }
    }

    public function testCreateSslCertificate()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SslCertificates/createSslCertificate.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $certificate = new SslCertificates($client);
        $result = $certificate->create(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            'My New Cert',
            '-----BEGIN CERTIFICATE-----abc123....-----END CERTIFICATE-----',
            '-----BEGIN RSA PRIVATE KEY-----secret....-----END RSA PRIVATE KEY-----',
            '-----BEGIN CERTIFICATE-----123abc....-----END CERTIFICATE-----',
            123,
            false
        );

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Installing the certificate.', $result->message);
    }

    public function testDeleteSslCertificate()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SslCertificates/deleteSslCertificate.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $certificate = new SslCertificates($client);
        $result = $certificate->delete('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 14);

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Deleting the certificate.', $result->message);
    }

    public function testActivateSslCertificate()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SslCertificates/activateSslCertificate.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $certificate = new SslCertificates($client);
        $result = $certificate->enable('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 2);

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Activating the certificate.', $result->message);
    }

    public function testDeactivateSslCertificate()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SslCertificates/deactivateSslCertificate.json');
        $client = $this->getMockClient($response);

        /** @var \AcquiaCloudApi\CloudApi\ClientInterface $client */
        $certificate = new SslCertificates($client);
        $result = $certificate->disable('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 2);

        $this->assertInstanceOf('\AcquiaCloudApi\Response\OperationResponse', $result);

        $this->assertEquals('Deactivating the certificate.', $result->message);
    }
}
