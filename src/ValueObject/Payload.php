<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\ValueObject;

use Http\Discovery\Psr17Factory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Trukes\ThreadsApiPhpClient\Transporter\ValueObject\AccessToken;
use Trukes\ThreadsApiPhpClient\Transporter\ValueObject\BaseUri;
use Trukes\ThreadsApiPhpClient\Transporter\ValueObject\BodyForm;
use Trukes\ThreadsApiPhpClient\Transporter\ValueObject\Headers;
use Trukes\ThreadsApiPhpClient\Transporter\ValueObject\QueryParams;
use Trukes\ThreadsApiPhpClient\Transporter\TransporterInterface;

final class Payload
{
    private function __construct(
        private readonly string $method,
        private readonly string $uri,
        private readonly array  $queryParameters = [],
        private readonly array  $bodyForm = [],
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

    public function toRequest(BaseUri $baseUri, AccessToken $accessToken, Headers $headers): RequestInterface
    {
        $psr17Factory = new Psr17Factory();

        $body = null;

        $uri = $baseUri->toString() . $this->uri;

        $queryParams = $this->queryParameters;
        if ($this->withAccessTokenOnQueryParams) {
            $queryParams = [...$queryParams, ...$accessToken->toQueryParameters()];
        }

        if ($queryParams !== []) {
            $uri .= '?' . http_build_query($queryParams);
        }

        $headers = $headers->withContentType('json');

        if (
            $this->method === TransporterInterface::POST
            && ([] !== $this->bodyForm)
        ) {
            $bodyForm = $this->bodyForm;
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
