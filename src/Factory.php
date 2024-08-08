<?php

namespace Trukes\ThreadsApiPhpClient;

use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Trukes\ThreadsApiPhpClient\DTO\Config;

final class Factory
{
    private Config $config;
    private ClientInterface $httpClient;
    private ?string $accessToken;

    public function withConfig(Config $config = new Config()): self
    {
        $this->config = $config;

        return $this;
    }

    public function withHttpClient(ClientInterface $httpClient): self
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    public function withAccessToken(string $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    public function make(): Client
    {
        $client = $this->httpClient ??= Psr18ClientDiscovery::find();

        $transporter = new Transporter($client, $this->config, $this->accessToken);
        return new Client($transporter);
    }
}