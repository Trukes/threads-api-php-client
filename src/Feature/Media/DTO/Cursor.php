<?php

namespace Trukes\ThreadsApiPhpClient\Feature\Media\DTO;

final class Cursor
{
    public function __construct(
        public readonly ?string $before,
        public readonly ?string $after,
    )
    {
    }
}