<?php

namespace Pixers\SalesManagoAPI\Exception;

use GuzzleHttp\Psr7\Response as Response;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class InvalidRequestException extends SalesManagoAPIException
{
    protected string $requestMethod;
    protected string $requestUrl;
    /**
     * @var array<mixed>
     */
    protected array $requestData;
    protected ResponseInterface $response;

    /**
     * @param array<mixed> $requestData
     */
    public function __construct(string $requestMethod, string $requestUrl, array $requestData, ResponseInterface $response)
    {
        $this->requestMethod = $requestMethod;
        $this->requestUrl = $requestUrl;
        $this->requestData = $requestData;
        $this->response = $response;

        parent::__construct('Error occured when sending request.');
    }

    public function getRequestMethod(): string
    {
        return $this->requestMethod;
    }

    public function getRequestUrl(): string
    {
        return $this->requestUrl;
    }

    /**
     * @return mixed[]
     */
    public function getRequestData(): array
    {
        return $this->requestData;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
