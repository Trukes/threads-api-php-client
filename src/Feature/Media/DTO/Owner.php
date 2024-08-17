<?php

namespace Trukes\ThreadsApiPhpClient\Feature\Media\DTO;

final class Owner
{
    public function __construct(public readonly ?int $id = null)
    {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
        ];
    }
}