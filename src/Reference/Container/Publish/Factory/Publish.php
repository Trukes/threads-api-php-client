<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Reference\Container\Publish\Factory;

use Trukes\ThreadsApiPhpClient\Reference\Shared\AbstractItemFactory;

final class Publish extends AbstractItemFactory
{
    private string $creationId;

    public function withCreationId(string $creationId): self
    {
        $this->creationId = $creationId;

        return $this;
    }

    public function toParams(): array
    {
        return [
            'creation_id' => $this->creationId
        ];
    }
}