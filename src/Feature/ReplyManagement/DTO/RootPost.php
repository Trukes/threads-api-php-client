<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\DTO;

final class RootPost
{
    private function __construct(public readonly ?int $id)
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(array_key_exists('id', $data) ? (int)$data['id'] : null);
    }
}