<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Reference\Container\ReplyManagement\Factory;

use Trukes\ThreadsApiPhpClient\Reference\Shared\AbstractItemFactory;

final class Replies extends AbstractItemFactory
{
    private ?string $fields = null;
    private ?bool $reverse = null;
    private ?string $before = null;
    private ?string $after = null;

    public function withFields(?string $fields): self
    {
        $this->fields = $fields;

        return $this;
    }
    public function withReverse(?bool $reverse): self
    {
        $this->reverse = $reverse;

        return $this;
    }
    public function withBefore(?string $before): self
    {
        $this->before = $before;

        return $this;
    }
    public function withAfter(?string $after): self
    {
        $this->after = $after;

        return $this;
    }

    public function toParams(): array
    {
        return [
            'fields' => $this->fields,
            'reverse' => $this->reverse,
            'before' => $this->before,
            'after' => $this->after,
        ];
    }
}