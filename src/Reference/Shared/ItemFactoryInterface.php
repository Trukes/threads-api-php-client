<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Reference\Shared;

interface ItemFactoryInterface
{
    public static function create(): self;

    public function toArray(): array;
}