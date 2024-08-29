<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Reference\Container\Publish\Factory;

use Trukes\ThreadsApiPhpClient\Reference\Shared\AbstractItemFactory;

final class Status extends AbstractItemFactory
{
    private ?string $fields;

    public function withFields(?string $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    public function toParams(): array
    {
        return [
            'fields' => $this->fields
        ];
    }
}