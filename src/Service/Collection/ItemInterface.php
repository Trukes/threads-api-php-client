<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Service\Collection;

interface ItemInterface
{
    public static function fromArray(array $item);
}