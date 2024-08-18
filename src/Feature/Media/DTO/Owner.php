<?php

namespace Trukes\ThreadsApiPhpClient\Feature\Media\DTO;

final class Owner
{
    private function __construct(public readonly ?int $id = null)
    {
    }

    public static function fromArray(array $data): self
    {
        return new self($data['id'] ?? null);
    }
}