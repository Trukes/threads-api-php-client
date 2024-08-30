<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Reference\Container\User\Factory;

use Trukes\ThreadsApiPhpClient\Reference\Shared\AbstractItemFactory;

final class PublishLimit extends AbstractItemFactory
{
    private ?string $fields = null;

    public function withFields(?string $fields = null): self
    {
        $this->fields = $fields;

        return $this;
    }

    public function toParams(): array
    {
        return ['fields' => $this->fields];
    }
}