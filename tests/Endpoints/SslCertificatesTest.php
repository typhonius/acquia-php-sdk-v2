<?php

namespace AcquiaCloudApi\Tests\Endpoints;

use AcquiaCloudApi\Tests\CloudApiTestCase;
use AcquiaCloudApi\Endpoints\SslCertificates;
use AcquiaCloudApi\Response\SslCertificatesResponse;
use AcquiaCloudApi\Response\SslCertificateResponse;

class SslCertificatesTest extends CloudApiTestCase
{
    public function testGetCertificates(): void
    {

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SslCertificates/getAllSslCertificates.json');
        $client = $this->getMockClient($response);

        $certificate = new SslCertificates($client);
        $result = $certificate->getAll('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851');

        $this->assertNotEmpty($result);

        foreach ($result as $record) {
            $this->assertInstanceOf(SslCertificateResponse::class, $record);
        }
    }

    public function testGetCertificate(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SslCertificates/getSslCertificate.json');
        $client = $this->getMockClient($response);

        $certificate = new SslCertificates($client);
        $result = $certificate->get('8ff6c046-ec64-4ce4-bea6-27845ec18600', 3);

        $this->assertNotInstanceOf(SslCertificatesResponse::class, $result);
    }

    public function testCreateSslCertificate(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SslCertificates/createSslCertificate.json');
        $client = $this->getMockClient($response);

        $certificate = new SslCertificates($client);
        $result = $certificate->create(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            'My New Cert',
            '-----BEGIN CERTIFICATE-----abc123....-----END CERTIFICATE-----',
            '-----BEGIN RSA PRIVATE KEY-----secret....-----END RSA PRIVATE KEY-----',
            '-----BEGIN CERTIFICATE-----123abc....-----END CERTIFICATE-----',
            123,
        );

        $requestOptions = [
            'json' => [
                'label' => 'My New Cert',
                'certificate' => '-----BEGIN CERTIFICATE-----abc123....-----END CERTIFICATE-----',
                'private_key' => '-----BEGIN RSA PRIVATE KEY-----secret....-----END RSA PRIVATE KEY-----',
                'ca_certificates' => '-----BEGIN CERTIFICATE-----123abc....-----END CERTIFICATE-----',
                'csr_id' => 123,
                'legacy' => false
            ],
        ];
        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals('Installing the certificate.', $result->message);
    }

    public function testCreateLegacySslCertificate(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SslCertificates/createSslCertificate.json');
        $client = $this->getMockClient($response);

        $certificate = new SslCertificates($client);
        $result = $certificate->create(
            '14-0c7e79ab-1c4a-424e-8446-76ae8be7e851',
            'My New Cert',
            '-----BEGIN CERTIFICATE-----abc123....-----END CERTIFICATE-----',
            '-----BEGIN RSA PRIVATE KEY-----secret....-----END RSA PRIVATE KEY-----',
            '-----BEGIN CERTIFICATE-----123abc....-----END CERTIFICATE-----',
            123,
            true
        );

        $requestOptions = [
            'json' => [
                'label' => 'My New Cert',
                'certificate' => '-----BEGIN CERTIFICATE-----abc123....-----END CERTIFICATE-----',
                'private_key' => '-----BEGIN RSA PRIVATE KEY-----secret....-----END RSA PRIVATE KEY-----',
                'ca_certificates' => '-----BEGIN CERTIFICATE-----123abc....-----END CERTIFICATE-----',
                'csr_id' => 123,
                'legacy' => true
            ],
        ];
        $this->assertEquals($requestOptions, $this->getRequestOptions($client));
        $this->assertEquals('Installing the certificate.', $result->message);
    }

    public function testDeleteSslCertificate(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SslCertificates/deleteSslCertificate.json');
        $client = $this->getMockClient($response);

        $certificate = new SslCertificates($client);
        $result = $certificate->delete('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 14);

        $this->assertEquals('Deleting the certificate.', $result->message);
    }

    public function testActivateSslCertificate(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SslCertificates/activateSslCertificate.json');
        $client = $this->getMockClient($response);

        $certificate = new SslCertificates($client);
        $result = $certificate->enable('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 2);

        $this->assertEquals('Activating the certificate.', $result->message);
    }

    public function testDeactivateSslCertificate(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/SslCertificates/deactivateSslCertificate.json');
        $client = $this->getMockClient($response);

        $certificate = new SslCertificates($client);
        $result = $certificate->disable('14-0c7e79ab-1c4a-424e-8446-76ae8be7e851', 2);

        $this->assertEquals('Deactivating the certificate.', $result->message);
    }
}
