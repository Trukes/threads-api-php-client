<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient;

use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Trukes\ThreadsApiPhpClient\Reference\Container\Insights\Insights;
use Trukes\ThreadsApiPhpClient\Reference\Container\Media\Media;
use Trukes\ThreadsApiPhpClient\Reference\Container\Publish\Publish;
use Trukes\ThreadsApiPhpClient\Reference\Container\ReplyManagement\ReplyManagement;
use Trukes\ThreadsApiPhpClient\Reference\Container\User\User;
use Trukes\ThreadsApiPhpClient\Transporter\Transporter;
use Trukes\ThreadsApiPhpClient\Transporter\ValueObject\AccessToken;
use Trukes\ThreadsApiPhpClient\Transporter\ValueObject\BaseUri;
use Trukes\ThreadsApiPhpClient\Transporter\ValueObject\BodyForm;
use Trukes\ThreadsApiPhpClient\Transporter\ValueObject\Headers;
use Trukes\ThreadsApiPhpClient\Transporter\ValueObject\QueryParams;
use Trukes\ThreadsApiPhpClient\ValueObject\Config;

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

        $baseUri = BaseUri::from($this->config->getGraphApiBaseUrl());

        $queryParams = QueryParams::create();

        $bodyForm = BodyForm::create();

        $accessToken = AccessToken::from($this->accessToken);

        $client = $this->httpClient ??= Psr18ClientDiscovery::find();

        $transporter = new Transporter($client, $baseUri, $headers, $queryParams, $bodyForm, $accessToken);

        return new Client(
            new Publish($transporter),
            new Media($transporter),
            new ReplyManagement($transporter),
            new User($transporter),
            new Insights($transporter)
        );
    }
}