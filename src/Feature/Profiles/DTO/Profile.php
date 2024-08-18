<?php

namespace Trukes\ThreadsApiPhpClient\Feature\Profiles\DTO;

use Trukes\ThreadsApiPhpClient\DTO\Response;
use Trukes\ThreadsApiPhpClient\Service\FromResponseInterface;

final class Profile implements FromResponseInterface
{
    private function __construct(
        public readonly ?string $id,
        public readonly ?string $username,
        public readonly ?string $name,
        public readonly ?string $threadsProfilePictureUrl,
        public readonly ?string $threadsBiography
    )
    {
    }

    public static function fromResponse(Response $response): self
    {
        return self::fromArray($response->data() ?? []);
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'] ?? null,
            $data['username'] ?? null,
            $data['name'] ?? null,
            $data['threads_profile_picture_url'] ?? null,
            $data['threads_biography'] ?? null
        );
    }
}