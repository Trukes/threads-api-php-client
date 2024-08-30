<?php

namespace Trukes\ThreadsApiPhpClient\ValueObject;

final class Config
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

    private string $graphApiBaseUrl;
    private string $authorizationBaseUrl;
    private ?string $graphApiVersion;

    public function __construct(
        ?string $graphApiVersion = 'v1.0',
        ?string $graphApiBaseUrl = 'https://graph.threads.net',
        ?string $authorizationBaseUrl = 'https://www.threads.net'
    )
    {
        $this->graphApiVersion = $graphApiVersion;
        $this->graphApiBaseUrl = $graphApiBaseUrl;
        $this->authorizationBaseUrl = $authorizationBaseUrl;

        if(null !== $graphApiVersion) {
            $this->graphApiBaseUrl = sprintf('%s/%s/', $graphApiBaseUrl, $graphApiVersion);
        }
    }

    public function getGraphApiBaseUrl(): string
    {
        return $this->graphApiBaseUrl;
    }

    public function getAuthorizationBaseUrl(): string
    {
        return $this->authorizationBaseUrl;
    }

    public function getGraphApiVersion(): ?string
    {
        return $this->graphApiVersion;
    }
}