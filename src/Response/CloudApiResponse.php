<?php
namespace AcquiaCloudApi\Response;

use Psr\Http\Message\ResponseInterface;

class CloudApiResponse
{

    public $response;

    function __construct(ResponseInterface $response)
    {
        $body = $response->getBody();

        $object = json_decode($body);
        if (json_last_error() === JSON_ERROR_NONE) {
            // JSON is valid
            if (property_exists($object, '_embedded') && property_exists($object->_embedded, 'items')) {

                $this->response = $object->_embedded->items;
            } else {
                $this->response = $object;
            }
        } else {
            $this->response = $body;
        }
    }
}