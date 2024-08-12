<?php

namespace Trukes\ThreadsApiPhpClient\DTO;

use Http\Discovery\Psr17Factory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Trukes\ThreadsApiPhpClient\DTO\Transporter\BaseUri;
use Trukes\ThreadsApiPhpClient\DTO\Transporter\Headers;
use Trukes\ThreadsApiPhpClient\DTO\Transporter\QueryParams;
use Trukes\ThreadsApiPhpClient\TransporterInterface;

final class Payload
{
    private function __construct(
        private readonly string $method,
        private readonly string $uri,
        private readonly array $queryParameters = [],
        private readonly array $body = [],
        private readonly array $headers = [],
    )
    {
    }

    public static function create(string $method ,string $uri, array $queryParameters = [], array $body = [], array $headers = []): self
    {
        return new self($method, $uri, $queryParameters, $body, $headers);
    }

    public function uri(?array $parameters = []): string
    {
        if(!empty($this->queryParameters)){
            return sprintf('%s?%s', $this->uri, http_build_query([...$this->queryParameters, ...$parameters]));
        }

        return $this->uri;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function options(): array
    {
        return [
            'headers' => $this->headers,
            'body' => $this->body,
        ];
    }

    public function toRequest(BaseUri $baseUri, Headers $headers, QueryParams $queryParams): RequestInterface
    {
        $psr17Factory = new Psr17Factory();

        $body = null;

        $uri = $baseUri->toString().$this->uri;

        $queryParams = $queryParams->toArray();
        if ($this->method === TransporterInterface::GET) {
            $queryParams = [...$queryParams, ...$this->queryParameters];
        }

        if ($queryParams !== []) {
            $uri .= '?'.http_build_query($queryParams);
        }

        $headers = $headers->withContentType('json');

        if ($this->method === TransporterInterface::POST) {
            $body = $psr17Factory->createStream(json_encode($this->queryParameters, JSON_THROW_ON_ERROR));
        }

        $request = $psr17Factory->createRequest($this->method, $uri);

        if ($body instanceof StreamInterface) {
            $request = $request->withBody($body);
        }

        foreach ($headers->toArray() as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        return $request;
    }
}