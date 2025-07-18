<?php

namespace AcquiaCloudApi\Connector;

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;
use Psr\Http\Message\ResponseInterface;

class OktaProvider extends GenericProvider
{
    /**
     * Checks a provider response for errors.
     *
     * @throws IdentityProviderException
     * @param  array<mixed>|string $data Parsed response data
     */
    protected function checkResponse(ResponseInterface $response, mixed $data): void
    {
        if (!empty($data['errorCode'])) {
            $error = $data['errorCode'];
            if (!is_string($error)) {
                $error = var_export($error, true);
            }
            throw new IdentityProviderException($error, 0, $data);
        }
        parent::checkResponse($response, $data);
    }
}
