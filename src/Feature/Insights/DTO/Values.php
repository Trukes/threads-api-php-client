<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Feature\Insights\DTO;

use Trukes\ThreadsApiPhpClient\Service\Collection\AbstractCollection;
use Trukes\ThreadsApiPhpClient\Service\Collection\ItemInterface;

final class Values extends AbstractCollection
{
    public function getItem(array $item): ItemInterface
    {
        return Value::fromArray($item);
    }
}