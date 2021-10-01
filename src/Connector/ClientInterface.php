<?php

namespace AcquiaCloudApi\Connector;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\BadResponseException;
use AcquiaCloudApi\Exception\ApiErrorException;
use Psr\Http\Message\StreamInterface;

/**
 * Interface ClientInterface
 *
 * @package AcquiaCloudApi\CloudApi
 */
interface ClientInterface
{
    /**
     * @var string VERSION
     */
    public const VERSION = '2.0.16-dev';

    /**
     * Returns the current version of the library.
     *
     * @return string
     * @throws \Exception
     */
    public function getVersion(): string;

    /**
     * Allows the library to modify the request prior to making the call to the API.
     *
     * @return array<string, mixed>
     */
    public function modifyOptions(): array;

    /**
     * Takes parameters passed in, makes a request to the API, and processes the response.
     *
     * @param string $verb
     * @param string $path
     * @param array<string, mixed> $options
     *
     * @return mixed
     */
    public function request(string $verb, string $path, array $options = []);

    /**
     * Takes parameters passed in, makes a request to the API, and streams the response.
     *
     * @param string $verb
     * @param string $path
     * @param array<string, mixed> $options
     *
     * @return StreamInterface
     */
    public function stream(string $verb, string $path, array $options = []);

    /**
     * @param  string $verb
     * @param  string $path
     * @param  array<string, mixed> $options
     * @return ResponseInterface
     */
    public function makeRequest(string $verb, string $path, array $options = []): ResponseInterface;

    /**
     * Processes the returned response from the API.
     *
     * @param  ResponseInterface $response
     * @return mixed
     * @throws \Exception
     */
    public function processResponse(ResponseInterface $response);

    /**
     * Get query from Client.
     *
     * @return array<string, mixed>
     */
    public function getQuery(): array;

    /**
     * Clear query.
     */
    public function clearQuery(): void;

    /**
     * Add a query parameter to filter results.
     *
     * @param string     $name
     * @param string|int $value
     */
    public function addQuery($name, $value): void;

    /**
     * Get options from Client.
     *
     * @return array<string, mixed>
     */
    public function getOptions(): array;

    /**
     * Clear options.
     */
    public function clearOptions(): void;

    /**
     * Add an option to the Guzzle request object.
     *
     * @param string $name
     * @param mixed  $value
     */
    public function addOption($name, $value): void;
}
