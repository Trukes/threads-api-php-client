<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Reference\Shared;

abstract class AbstractItemFactory implements ItemFactoryInterface
{
    public static function create(): static
    {
        return new static();
    }

    public function toArray(): array
    {
        return array_filter($this->toParams());
    }

    abstract public function toParams(): array;
}