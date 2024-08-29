<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\DTO;

use Http\Discovery\Psr17Factory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Trukes\ThreadsApiPhpClient\DTO\Transporter\AccessToken;
use Trukes\ThreadsApiPhpClient\DTO\Transporter\BaseUri;
use Trukes\ThreadsApiPhpClient\DTO\Transporter\BodyForm;
use Trukes\ThreadsApiPhpClient\DTO\Transporter\Headers;
use Trukes\ThreadsApiPhpClient\DTO\Transporter\QueryParams;
use Trukes\ThreadsApiPhpClient\TransporterInterface;

final class Payload
{
    private function __construct(
        private readonly string $method,
        private readonly string $uri,
        private array           $queryParameters = [],
        private array           $bodyForm = [],
        private bool            $withAccessTokenOnQueryParams = true,
        private bool            $withAccessTokenOnBodyForm = false,
    )
    {
    }

    public static function create(string $method, string $uri, array $queryParameters = [], array $bodyForm = []): self
    {
        return new self($method, $uri, $queryParameters, $bodyForm);
    }

    public function method(): string
    {
        return $this->method;
    }

    public function withAccessTokenOnQueryParams(bool $value): self
    {
        $this->withAccessTokenOnQueryParams = $value;

        return $this;
    }

    public function withAccessTokenOnBodyForm(bool $value): self
    {
        $this->withAccessTokenOnBodyForm = $value;

        return $this;
    }

    public function toRequest(BaseUri $baseUri, AccessToken $accessToken, Headers $headers, QueryParams $queryParams, BodyForm $bodyForm): RequestInterface
    {
        $psr17Factory = new Psr17Factory();

        $body = null;

        $uri = $baseUri->toString() . $this->uri;

        $queryParams = $queryParams->toArray();
        if ($this->method === TransporterInterface::GET) {
            $queryParams = [...$queryParams, ...$this->queryParameters];
        }

        if ($this->withAccessTokenOnQueryParams) {
            $queryParams = [...$queryParams, ...$accessToken->toQueryParameters()];
        }

        if ($queryParams !== []) {
            $uri .= '?' . http_build_query($queryParams);
        }

        $headers = $headers->withContentType('json');

        if (
            $this->method === TransporterInterface::POST
            && ([] !== $this->bodyForm || [] !== $bodyForm->toArray())
        ) {
            $bodyForm = [...$bodyForm->toArray(), ...$this->bodyForm];
            if ($this->withAccessTokenOnBodyForm) {
                $bodyForm = [...$bodyForm, ...$accessToken->toBodyFormParameters()];
            }
            $body = $psr17Factory->createStream($this->buildMultipartBody($bodyForm));
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

    private function buildMultipartBody(array $bodyForm): string
    {
        return json_encode($bodyForm);
    }
}
