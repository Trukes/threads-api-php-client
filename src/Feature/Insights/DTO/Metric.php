<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Feature\Insights\DTO;

use Trukes\ThreadsApiPhpClient\Service\Collection\ItemInterface;

final class Metric implements ItemInterface
{
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $period,
        public readonly ?string $title,
        public readonly ?string $description,
        public readonly ?string $id,
        public readonly Values  $values,
    )
    {
    }

    public static function fromArray(array $item)
    {
        return new self(
            $item['name'] ?? null,
            $item['period'] ?? null,
            $item['title'] ?? null,
            $item['description'] ?? null,
            $item['id'] ?? null,
            Values::fromArray($item['values'] ?? null),
        );
    }
}