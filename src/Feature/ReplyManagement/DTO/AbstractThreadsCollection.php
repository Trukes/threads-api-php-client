<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Feature\ReplyManagement\DTO;

use Trukes\ThreadsApiPhpClient\Service\Collection\AbstractCollection;
use Trukes\ThreadsApiPhpClient\Service\Collection\ItemInterface;
use Trukes\ThreadsApiPhpClient\Service\FromResponseInterface;

abstract class AbstractThreadsCollection extends AbstractCollection implements FromResponseInterface
{
    public function getItem(array $item): ItemInterface
    {
        return Thread::fromArray($item);
    }
}
