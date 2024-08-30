<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Transporter\ValueObject;

final class Headers
{
    /**
     * Creates a new Headers value object.
     *
     * @param  array<string, string>  $headers
     */
    private function __construct(private readonly array $headers)
    {
        // ..
    }

    /**
     * Creates a new Headers value object
     */
    public static function create(): self
    {
        return new self([]);
    }


    /**
     * Creates a new Headers value object, with the given content type, and the existing headers.
     */
    public function withContentType(string $contentType, string $suffix = ''): self
    {
        return new self([
            ...$this->headers,
            'Content-Type' => $contentType.$suffix,
        ]);
    }

    /**
     * @return array<string, string> $headers
     */
    public function toArray(): array
    {
        return $this->headers;
    }
}
