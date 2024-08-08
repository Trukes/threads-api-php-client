<?php

namespace Trukes\ThreadsApiPhpClient;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Trukes\ThreadsApiPhpClient\DTO\Config;

final class Transporter implements TransporterInterface
{
    public function __construct(
        private ClientInterface $httpClient,
        private Config $config,
        private ?string $accessToken,
    )
    {
    }

    public function request(string $method, $uri, array $options = []): ResponseInterface
    {
        return $this->httpClient->request(
            $method,
            sprintf('%s/%s',$this->config->getGraphApiBaseUrl(), $uri),
            $options
        );
    }
}