<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Reference\Container\User\Factory;

use Trukes\ThreadsApiPhpClient\Reference\Shared\AbstractItemFactory;

final class Replies extends AbstractItemFactory
{
    private ?string $fields = null;
    private ?string $since = null;
    private ?string $until = null;
    private ?int $limit = null;
    private ?string $before = null;
    private ?string $after = null;


    public function withFields(?string $fields): self
    {
        $this->fields = $fields;

        return $this;
    }
    public function withSince(?string $since): self
    {
        $this->since = $since;

        return $this;
    }
    public function withUntil(?string $until): self
    {
        $this->until = $until;

        return $this;
    }
    public function withLimit(?int $limit): self
    {
        $this->limit = $limit;

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
            'since' => $this->since,
            'until' => $this->until,
            'limit' => $this->limit,
            'before' => $this->before,
            'after' => $this->after,
        ];
    }
}