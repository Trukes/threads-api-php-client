<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Feature\Media\DTO;

use Trukes\ThreadsApiPhpClient\Service\Collection\AbstractCollection;
use Trukes\ThreadsApiPhpClient\Service\Collection\ItemInterface;

final class Collection extends AbstractCollection
{
    public function getItem(array $item): ItemInterface
    {
        return Item::fromArray($item);
    }
}