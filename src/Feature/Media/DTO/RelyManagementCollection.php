<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Feature\Media\DTO;

use Trukes\ThreadsApiPhpClient\Service\Collection\AbstractRelyManagementCollection;
use Trukes\ThreadsApiPhpClient\Service\Collection\ItemInterface;

final class RelyManagementCollection extends AbstractRelyManagementCollection
{
    public function getItem(array $item): ItemInterface
    {
        return Item::fromArray($item);
    }
}