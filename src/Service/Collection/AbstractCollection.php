<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Service\Collection;

abstract class AbstractCollection
{
    protected array $data = [];

    protected function __construct()
    {
    }

    public static function fromArray(array $data): static
    {
        $collection = new static();
        foreach ($data as $item) {
            $collection->append($collection->getItem($item));
        }

        return $collection;
    }

    abstract public function getItem(array $item): ItemInterface;

    public function append(ItemInterface $item): self
    {
        $this->data[] = $item;

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }
}