<?php

namespace Trukes\ThreadsApiPhpClient\Service\Paging;

final class Cursor
{
    public function __construct(
        public readonly ?string $before,
        public readonly ?string $after,
    )
    {
    }
}