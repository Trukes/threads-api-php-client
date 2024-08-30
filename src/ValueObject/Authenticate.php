<?php

namespace Trukes\ThreadsApiPhpClient\ValueObject;

use Trukes\ThreadsApiPhpClient\Secrets\Token;

final class Authenticate
{
    #APP_ID=YOUR_APP_ID
    #API_SECRET=YOUR_APP_SECRET
    #SESSION_SECRET=RANDOM_SESSION_SECRET_STRING

    # Optional config setting to change the Graph API version.
    # Leave blank or commented to default to the app's default version
    # GRAPH_API_VERSION=v1.0

    # If both INITIAL_ACCESS_TOKEN and INITIAL_USER_ID are provided, then the authentication step is bypassed once.
    # These settings can be useful when testing the publishing or reading functionality, as it
    # prevents having to authenticate each time the session is destroyed.
    # INITIAL_ACCESS_TOKEN=SOME-ACCESS-TOKEN
    # INITIAL_USER_ID=SOME-USER-ID

    private string $appId;
    private string $apiSecret;
    private ?string $initialAccessToken;
    private ?string $initialUserId;
    private ?string $redirectUri; // https://threads-sample.meta:8000/callback

    private Token $token;

    public function __construct(
        ?string $appId = null,
        ?string $apiSecret = null,
        ?string $redirectUri = null,
        ?string $initialAccessToken = null,
        ?string $initialUserId = null
    )
    {
        $this->appId = $appId;
        $this->apiSecret = $apiSecret;
        $this->redirectUri = $redirectUri;
        $this->initialAccessToken = $initialAccessToken;
        $this->initialUserId = $initialUserId;

        $this->token = new Token();
    }

    public function getAppId(): string
    {
        return $this->appId;
    }

    public function getApiSecret(): string
    {
        return $this->apiSecret;
    }

    public function getInitialAccessToken(): ?string
    {
        return $this->initialAccessToken;
    }

    public function getInitialUserId(): ?string
    {
        return $this->initialUserId;
    }

    public function getRedirectUri(): ?string
    {
        return $this->redirectUri;
    }

    public function getToken(): Token
    {
        return $this->token;
    }
}