<?php

namespace Pixers\SalesManagoAPI\Exception;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Throwable;

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
    public function __construct(string $requestMethod, string $requestUrl, array $requestData, ResponseInterface $response, ?Throwable $previous = null)
    {
        $this->requestMethod = $requestMethod;
        $this->requestUrl = $requestUrl;
        $this->requestData = $requestData;
        $this->response = $response;

        $message = vsprintf('Error occured when sending request. Method: %, url: %s, request data: %s. Response: %', [
            $requestMethod,
            $requestUrl,
            json_encode($requestData),
            Response\Serializer::toString($response),
        ]);

        parent::__construct($message, 0, $previous);
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
