<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Transporter\ValueObject;

final class AccessToken
{
    /**
     * Creates a new Base URI value object.
     */
    private function __construct(public readonly ?string $accessToken = null)
    {
    }

    /**
     * Creates a new Base URI value object.
     */
    public static function from(string $accessToken): self
    {
        return new self($accessToken);
    }

    public function toQueryParameters(): array
    {
        return null !== $this->accessToken ? ['access_token' => $this->accessToken] : [];
    }

    public function toBodyFormParameters(): array
    {
        return null !== $this->accessToken ? ['access_token' => $this->accessToken] : [];
    }
}