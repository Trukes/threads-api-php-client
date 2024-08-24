<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Feature\Insights\DTO;

use Trukes\ThreadsApiPhpClient\Service\Collection\ItemInterface;

final class Value implements ItemInterface
{
    private function __construct(public readonly ?int $value)
    {
    }

    public static function fromArray(array $item): self
    {
        return new self((int) $item['value'] ?? null);
    }
}