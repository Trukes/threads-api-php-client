<?php

namespace Trukes\ThreadsApiPhpClient\Secrets;

final class Token
{
    private ?string $token;
    public function __construct(?string $token = null)
    {
        $this->token = $token;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'access_token' => $this->getToken(),
        ];
    }
}