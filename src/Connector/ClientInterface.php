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
     * @param array<string, mixed> $options
     *
     */
    public function request(string $verb, string $path, array $options = []): mixed;

    /**
     * Takes parameters passed in, makes a request to the API, and streams the response.
     *
     * @param array<string, mixed> $options
     *
     */
    public function stream(string $verb, string $path, array $options = []): StreamInterface;

    /**
     * @param  array<string, mixed> $options
     */
    public function makeRequest(string $verb, string $path, array $options = []): ResponseInterface;

    /**
     * Processes the returned response from the API.
     *
     * @throws \Exception
     */
    public function processResponse(ResponseInterface $response): mixed;

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
     */
    public function addQuery(string $name, int|string $value): void;

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
     */
    public function addOption(string $name, mixed $value): void;
}
