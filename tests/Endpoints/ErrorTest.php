<?php

class ErrorTest extends CloudApiTestCase
{

    public function testError403()
    {

        try {
            $this->generateCloudApiResponse('Endpoints/error403.json');
            // Fail if we don't throw an error.
        } catch (Exception $e) {
            $message = $e->getMessage();

            $client = $this->getMockBuilder('\AcquiaCloudApi\CloudApi\Client')
              ->disableOriginalConstructor()
              ->setMethods(['applications'])
              ->getMock();

            $client->expects($this->once())
              ->method('applications')
              ->willThrowException(new Exception($message));

            try {
                /** @var AcquiaCloudApi\CloudApi\Client $client */
                $client->applications();
            } catch (Exception $e) {
                $this->assertEquals($e->getMessage(), 'You do not have permission to view applications.');

                return;
            }
        }

        // Fail if we don't throw an error.
        $this->fail();
    }
}
