<?php

namespace Pixers\SalesManagoAPI;

use GuzzleHttp\Utils;
use GuzzleHttp\Client as GuzzleClient;
use Pixers\SalesManagoAPI\Exception\InvalidRequestException;
use Pixers\SalesManagoAPI\Exception\InvalidArgumentException;

/**
 * SalesManago API implementation.
 *
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 * @author Michał Kanak <michal.kanak@pixers.pl>
 */
class Client
{
    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';

    /** @var string[] */
    protected array $config;

    protected GuzzleClient $guzzleClient;

    public function __construct(
        GuzzleClient $guzzleClient,
        string $clientId,
        string $endPoint,
        string $apiSecret,
        string $apiKey
    ) {
        $this->guzzleClient = $guzzleClient;
        $this->config = [
            'client_id' => $clientId,
            'endpoint' => rtrim($endPoint, '/') . '/',
            'api_secret' => $apiSecret,
            'api_key' => $apiKey
        ];

        foreach ($this->config as $key => $parameter) {
            if (empty($parameter)) {
                throw new InvalidArgumentException($key . ' parameter is required', $parameter);
            }
        }
    }

    /**
     * Send POST request to SalesManago API.
     *
     * @param  array<string, mixed>  $data   Request data
     */
    public function doPost(string $method, array $data): object
    {
        return $this->doRequest(self::METHOD_POST, $method, $data);
    }

    /**
     * Send GET request to SalesManago API.
     *
     * @param  array<string, mixed>  $data   Request data
     */
    public function doGet(string $method, array $data): object
    {
        return $this->doRequest(self::METHOD_GET, $method, $data);
    }

    /**
     * Send request to SalesManago API.
     *
     * @param  array<string, mixed>  $data      Request data
     */
    protected function doRequest(string $method, string $apiMethod, array $data = []): object
    {
        $url = $this->config['endpoint'] . $apiMethod;
        $data = $this->mergeData($this->createAuthData(), $data);

        $response = $this->guzzleClient->request($method, $url, [
            'json' => $data,
            'http_errors' => false,
        ]);
        $responseContent = Utils::jsonDecode((string) $response->getBody());

        if (!is_object($responseContent) || !property_exists($responseContent, 'success') || !$responseContent->success) {
            throw new InvalidRequestException($method, $url, $data, $response);
        }

        return $responseContent;
    }

    /**
     * Returns an array of authentication data.
     * @return array<string, mixed>
     */
    protected function createAuthData(): array
    {
        return [
            'clientId' => $this->config['client_id'],
            'apiKey' => $this->config['api_key'],
            'requestTime' => time(),
            'sha' => sha1($this->config['api_key'] . $this->config['client_id'] . $this->config['api_secret'])
        ];
    }

    /**
     * Merge data and removing null values.
     *
     * @param  array<string, mixed> $base         The array in which elements are replaced
     * @param  array<string, mixed> $replacements The array from which elements will be extracted
     * @return array<string, mixed>
     */
    private function mergeData(array $base, array $replacements): array
    {
        return array_filter(array_merge($base, $replacements), fn ($value) => $value !== null);
    }
}
