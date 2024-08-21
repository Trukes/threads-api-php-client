<?php

namespace Trukes\ThreadsApiPhpClient;

use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Trukes\ThreadsApiPhpClient\DTO\Config;
use Trukes\ThreadsApiPhpClient\DTO\Transporter\AccessToken;
use Trukes\ThreadsApiPhpClient\DTO\Transporter\BaseUri;
use Trukes\ThreadsApiPhpClient\DTO\Transporter\BodyForm;
use Trukes\ThreadsApiPhpClient\DTO\Transporter\Headers;
use Trukes\ThreadsApiPhpClient\DTO\Transporter\QueryParams;

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
        $headers = Headers::create();

        /*foreach ($this->headers as $name => $value) {
            $headers = $headers->withCustomHeader($name, $value);
        }*/

        $baseUri = BaseUri::from($this->config->getGraphApiBaseUrl());

        $queryParams = QueryParams::create();

        $bodyForm = BodyForm::create();

        $accessToken = AccessToken::from($this->accessToken);

        /*        foreach ($this->queryParams as $name => $value) {
                    $queryParams = $queryParams->withParam($name, $value);
                }*/

        $client = $this->httpClient ??= Psr18ClientDiscovery::find();

        $transporter = new Transporter($client, $baseUri, $headers, $queryParams, $bodyForm, $accessToken);

        return new Client($transporter);
    }
}